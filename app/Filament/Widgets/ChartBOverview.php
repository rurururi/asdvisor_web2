<?php

namespace App\Filament\Widgets;

use App\Models\Child;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ChartBOverview extends ChartWidget
{
    protected static ?string $heading = 'User Creation Chart';

    protected function getData(): array
    {
        $datasets = [];
        if(auth()->user()->account_level == "Administrator") {
            $datasets = [
                [
                    'label' => 'Administrator(s)',
                    'data' => Trend::query(User::where('account_level', '=', 'Administrator'))->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )->perMonth()
                    ->count()->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#5cb85c',
                    'backgroundColor' => '#5cb85c',
                ],
                [
                    'label' => 'Doctor(s)',
                    'data' => Trend::query(User::where('account_level', '=', 'Doctor'))->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )->perMonth()
                    ->count()->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#ff0000',
                    'backgroundColor' => '#ff0000',
                ],
                [
                    'label' => 'Parent(s)',
                    'data' => Trend::query(User::where('account_level', '=', 'Parents'))->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )->perMonth()
                    ->count()->map(fn (TrendValue $value) => $value->aggregate),
                ],
                [
                    'label' => 'Child(s)',
                    'data' => Trend::model(Child::class)->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )->perMonth()
                    ->count()->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#0000ff',
                    'backgroundColor' => '#0000ff',
                ],
            ];
        } else if(auth()->user()->account_level == "Doctor") {
            $datasets = [
                [
                    'label' => 'Parent(s)',
                    'data' => Trend::query(User::where('account_level', '=', 'Parents'))->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )->perMonth()
                    ->count()->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#5cb85c',
                    'backgroundColor' => '#5cb85c',
                ],
                [
                    'label' => 'Child(s)',
                    'data' => Trend::model(Child::class)->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )->perMonth()
                    ->count()->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#0000ff',
                    'backgroundColor' => '#0000ff',
                ],
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => ['Jan ' . date("Y"), 'Feb ' . date("Y"), 'Mar '. date("Y"), 'Apr '. date("Y"), 'May '. date("Y"), 'Jun '. date("Y"), 'Jul '. date("Y"), 'Aug '. date("Y"), 'Sep '. date("Y"), 'Oct '. date("Y"), 'Nov '. date("Y"), 'Dec '. date("Y")]
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public static function canView(): bool
    {
        if(auth()->user()->account_level == "Administrator" || auth()->user()->account_level == "Doctor") {
            return true;
        }

        return false;
    }
}
