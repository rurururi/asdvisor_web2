<?php

namespace App\Filament\Widgets;

use App\Models\Child;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AStatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        $stats = [];
        if(auth()->user()->account_level == "Administrator") {
            $stats = [
                Stat::make('Total Administrator(s)', User::all()->where('account_level','Administrator')->count()),
                Stat::make('Total Doctor(s)', User::all()->where('account_level','Doctor')->count()),
                Stat::make('Total Parent(s)', User::all()->where('account_level','Parents')->count())
                ->description('Increase in parents')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                Stat::make('Total Child(s)', Child::all()->count()),
            ];
        } else if(auth()->user()->account_level == "Doctor") {
            $stats = [
                Stat::make('Total Doctor(s)', User::all()->where('account_level','Doctor')->count()),
                Stat::make('Total Parent(s)', User::all()->where('account_level','Parents')->count())
                ->description('Increase in parents')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                Stat::make('Total Child(s)', Child::all()->count()),
            ];
        } else if(auth()->user()->account_level == "Parents") {
            $stats = [
                Stat::make('Total Child(s)', Child::all()->where('parent_id', auth()->user()->id)->count())
            ];
        }
        return $stats;
    }
}
