<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubjectResource\Pages;
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
use Filament\Forms\Components\Select;
use App\Filament\Resources\SubjectResource\Schemas\SubjectForm;
use BackedEnum;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Courses';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return SubjectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-book-open')
                    ->weight('bold'),
                TextColumn::make('teacher.name')
                    ->label('Teacher')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-m-academic-cap'),
                BadgeColumn::make('code')
                    ->label('Join Code')
                    ->icon('heroicon-m-hashtag'),
                TextColumn::make('students_count')
                    ->label('Students')
                    ->counts('students')
                    ->icon('heroicon-m-user-group'),
                TextColumn::make('assignments_count')
                    ->label('Assignments')
                    ->counts('assignments')
                    ->icon('heroicon-m-list-bullet'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created'),
            ])
            ->filters([
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
            'index' => Pages\ListSubjects::route('/'),
            'create' => Pages\CreateSubject::route('/create'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
        ];
    }
}
