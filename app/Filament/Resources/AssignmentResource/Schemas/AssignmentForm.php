<?php

namespace App\Filament\Resources\AssignmentResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Assignment Title'),

                Select::make('subject_id')
                    ->label('Course')
                    ->options(fn() => \App\Models\Subject::pluck('name', 'id')->toArray())
                    ->required()
                    ->searchable()
                    ->preload(),

                Textarea::make('description')
                    ->placeholder('Assignment description and instructions')
                    ->rows(5)
                    ->columnSpanFull(),

                DateTimePicker::make('due_date')
                    ->required(),

                Select::make('teacher_id')
                    ->label('Teacher')
                    ->options(fn() => \App\Models\User::where('role', 'teacher')->pluck('name', 'id')->toArray())
                    ->required()
                    ->searchable()
                    ->preload(),
            ]);
    }
}
