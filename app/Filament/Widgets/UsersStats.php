<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\User;

class UsersStats extends BaseWidget
{
    protected static ?string $heading = 'Lietotāju Statistika';

    protected function getCards(): array
    {
        $total = User::count();
        $admins = User::where('role', 'admin')->count();
        $teachers = User::where('role', 'teacher')->count();
        $students = User::where('role', 'student')->count();

        return [
            Card::make('Kopā lietotāji', $total),
            Card::make('Administratori', $admins)->color('danger'),
            Card::make('Skolotāji', $teachers)->color('primary'),
            Card::make('Studenti', $students)->color('success'),
        ];
    }
}
