<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget as StatsOverviewWidgetBase;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Widget;
use App\Models\User;
use App\Models\Subject;
use App\Models\Assignment;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            DashboardStatsOverview::class,
        ];
    }
}

class DashboardStatsOverview extends StatsOverviewWidgetBase
{
    protected function getStats(): array
    {
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalCourses = Subject::count();
        $totalAssignments = Assignment::count();
        $averageGrade = Grade::avg('grade') ?? 0;

        return [
            Stat::make('Total Users', $totalUsers)
                ->description('All registered users')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->icon('heroicon-o-user-group'),
            
            Stat::make('Students', $totalStudents)
                ->description('Active learners')
                ->descriptionIcon('heroicon-m-book-open')
                ->color('success')
                ->icon('heroicon-o-book-open'),
            
            Stat::make('Teachers', $totalTeachers)
                ->description('Instructors')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info')
                ->icon('heroicon-o-academic-cap'),
            
            Stat::make('Courses', $totalCourses)
                ->description('Active courses')
                ->descriptionIcon('heroicon-m-list-bullet')
                ->color('warning')
                ->icon('heroicon-o-list-bullet'),
            
            Stat::make('Assignments', $totalAssignments)
                ->description('Total assignments')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('danger')
                ->icon('heroicon-o-clipboard-document-list'),
            
            Stat::make('Avg Grade', round($averageGrade, 2))
                ->description('Class average')
                ->descriptionIcon('heroicon-m-star')
                ->color('success')
                ->icon('heroicon-o-star'),
        ];
    }
}
