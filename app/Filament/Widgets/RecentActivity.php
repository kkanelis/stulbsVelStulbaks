<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\AssignmentFile;

class RecentActivity extends Widget
{
    protected static string $view = 'filament.widgets.recent-activity';

    public function getRecentSubmissions()
    {
        return AssignmentFile::with('user', 'assignment')->latest()->limit(8)->get();
    }
}
