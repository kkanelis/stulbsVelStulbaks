<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentResource\Pages;
use App\Models\Assignment;
use App\Models\Subject;
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
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use App\Filament\Resources\AssignmentResource\Schemas\AssignmentForm;
use BackedEnum;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Assignments';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return AssignmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-clipboard-document-list')
                    ->weight('bold'),
                TextColumn::make('subject.name')
                    ->label('Course')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-book-open'),
                TextColumn::make('teacher.name')
                    ->label('Teacher')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-academic-cap'),
                TextColumn::make('due_date')
                    ->dateTime()
                    ->sortable()
                    ->label('Due Date')
                    ->icon('heroicon-m-calendar'),
                BadgeColumn::make('grades_count')
                    ->label('Graded')
                    ->counts('grades')
                    ->icon('heroicon-m-check-circle'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created'),
            ])
            ->filters([
                SelectFilter::make('subject_id')
                    ->label('Filter by Course')
                    ->options(
                        Subject::pluck('name', 'id')
                    ),
                SelectFilter::make('teacher_id')
                    ->label('Filter by Teacher')
                    ->options(
                        User::where('role', 'teacher')->pluck('name', 'id')
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
            ->defaultSort('due_date', 'desc');
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
            'index' => Pages\ListAssignments::route('/'),
            'create' => Pages\CreateAssignment::route('/create'),
            'edit' => Pages\EditAssignment::route('/{record}/edit'),
        ];
    }
}
