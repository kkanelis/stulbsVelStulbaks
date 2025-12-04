<?php

namespace App\Filament\Resources\GradeResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class GradeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->label('Student')
                    ->options(fn() => \App\Models\User::where('role', 'student')->pluck('name', 'id')->toArray())
                    ->required()
                    ->searchable()
                    ->preload(),

                Select::make('assignment_id')
                    ->label('Assignment')
                    ->options(fn() => \App\Models\Assignment::pluck('title', 'id')->toArray())
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('grade')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->maxValue(100)
                    ->placeholder('0-100'),

                Textarea::make('feedback')
                    ->placeholder('Provide constructive feedback to the student')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
