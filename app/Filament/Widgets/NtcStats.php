<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class NtcStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalArticles = Article::count();
        $published = Article::where('is_published', true)->count();
        $drafts = $totalArticles - $published;

        return [
            Stat::make('Total Artikel', number_format($totalArticles))
                ->description('Semua artikel di CMS')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),
            Stat::make('Published', number_format($published))
                ->description('Tayang di website')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color('success'),
            Stat::make('Admin Aktif', number_format(User::count()))
                ->description("{$drafts} draft menunggu tayang")
                ->descriptionIcon('heroicon-o-user-group')
                ->color('warning'),
        ];
    }
}
