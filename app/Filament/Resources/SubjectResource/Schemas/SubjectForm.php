<?php

namespace App\Filament\Resources\SubjectResource\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Course Name'),

                Select::make('teacher_id')
                    ->label('Teacher')
                    ->options(fn() => \App\Models\User::where('role', 'teacher')->pluck('name', 'id')->toArray())
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('code')
                    ->required()
                    ->maxLength(6)
                    ->placeholder('6-letter code (auto-generated)')
                    ->disabled(),
            ]);
    }
}
