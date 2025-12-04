<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GradeResource\Pages;
use App\Models\Grade;
use App\Models\Assignment;
use App\Models\User;
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
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use App\Filament\Resources\GradeResource\Schemas\GradeForm;
use BackedEnum;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Grades';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return GradeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->label('Student')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-user')
                    ->weight('bold'),
                TextColumn::make('assignment.title')
                    ->label('Assignment')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-clipboard-document-list'),
                BadgeColumn::make('grade')
                    ->sortable()
                    ->colors([
                        'danger' => static fn($state) => (int)$state < 50,
                        'warning' => static fn($state) => (int)$state >= 50 && (int)$state < 75,
                        'success' => static fn($state) => (int)$state >= 75,
                    ])
                    ->icons([
                        'heroicon-m-exclamation-circle' => static fn($state) => (int)$state < 50,
                        'heroicon-m-information-circle' => static fn($state) => (int)$state >= 50 && (int)$state < 75,
                        'heroicon-m-check-circle' => static fn($state) => (int)$state >= 75,
                    ])
                    ->suffix('/100'),
                TextColumn::make('feedback')
                    ->limit(50)
                    ->tooltip(function(TextColumn $column): ?string {
                        return $column->getState();
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Graded'),
            ])
            ->filters([
                SelectFilter::make('student_id')
                    ->label('Filter by Student')
                    ->options(
                        User::where('role', 'student')->pluck('name', 'id')
                    ),
                SelectFilter::make('assignment_id')
                    ->label('Filter by Assignment')
                    ->options(
                        Assignment::pluck('title', 'id')
                    ),
            ])
            ->actions([
                EditAction::make()
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
            'index' => Pages\ListGrades::route('/'),
            'create' => Pages\CreateGrade::route('/create'),
            'edit' => Pages\EditGrade::route('/{record}/edit'),
        ];
    }
}
