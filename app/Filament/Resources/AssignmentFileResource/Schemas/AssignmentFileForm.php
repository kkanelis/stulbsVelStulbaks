<?php

namespace App\Filament\Resources\AssignmentFileResource\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class AssignmentFileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('assignment_id')
                    ->label('Assignment')
                    ->options(fn() => \App\Models\Assignment::pluck('title', 'id')->toArray())
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('original_name')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),

                TextInput::make('path')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),

                TextInput::make('size')
                    ->numeric()
                    ->disabled()
                    ->formatStateUsing(fn($state) => round($state / 1024, 2) . ' KB'),
            ]);
    }
}
