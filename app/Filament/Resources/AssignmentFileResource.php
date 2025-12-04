<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentFileResource\Pages;
use App\Models\AssignmentFile;
use App\Models\Assignment;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Filament\Resources\AssignmentFileResource\Schemas\AssignmentFileForm;
use BackedEnum;
use Illuminate\Support\Facades\Storage;

class AssignmentFileResource extends Resource
{
    protected static ?string $model = AssignmentFile::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'Files';
    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return AssignmentFileForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('original_name')
                    ->label('File Name')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-document')
                    ->weight('bold'),
                TextColumn::make('assignment.title')
                    ->label('Assignment')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-clipboard-document-list'),
                TextColumn::make('user.name')
                    ->label('Uploaded By')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-user'),
                TextColumn::make('size')
                    ->label('Size')
                    ->formatStateUsing(fn($state) => round($state / 1024, 2) . ' KB'),
                BadgeColumn::make('mime')
                    ->label('Type')
                    ->formatStateUsing(fn($state) => strtoupper(pathinfo($state, PATHINFO_EXTENSION)) ?: 'FILE'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Uploaded'),
            ])
            ->filters([
                SelectFilter::make('assignment_id')
                    ->label('Filter by Assignment')
                    ->options(
                        Assignment::pluck('title', 'id')
                    ),
            ])
            ->actions([
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->action(function(AssignmentFile $record) {
                        return Storage::disk('public')->download($record->path, $record->original_name);
                    })
                    ->button(),
                DeleteAction::make()
                    ->button(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssignmentFiles::route('/'),
        ];
    }
}
