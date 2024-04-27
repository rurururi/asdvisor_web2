<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ChartAOverview extends ChartWidget
{
    protected static ?string $heading = 'Appointments Chart';

    protected function getData(): array
    {
        $datasets = [];
        if(auth()->user()->account_level == "Administrator") {
            $datasets = [
                [
                    'label' => 'Approved',
                    'data' => Trend::query(Appointment::where('status', '=', 'Approved'))->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )->perMonth()
                    ->count()->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#5cb85c',
                    'backgroundColor' => '#5cb85c',
                ],
                [
                    'label' => 'Rejected',
                    'data' => Trend::query(Appointment::where('status', '=', 'Rejected'))->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )->perMonth()
                    ->count()->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#ff0000',
                    'backgroundColor' => '#ff0000',
                ],
                [
                    'label' => 'Pending',
                    'data' => Trend::query(Appointment::where('status', '=', 'Pending'))->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )->perMonth()
                    ->count()->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ];
        } else if(auth()->user()->account_level == "Doctor") {
            $datasets = [
                [
                    'label' => 'Approved',
                    'data' => Trend::query(Appointment::where('status', '=', 'Approved')->where('doctor_id', auth()->user()->id))->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )->perMonth()
                    ->count()->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#5cb85c',
                    'backgroundColor' => '#5cb85c',
                ],
                [
                    'label' => 'Rejected',
                    'data' => Trend::query(Appointment::where('status', '=', 'Rejected')->where('doctor_id', auth()->user()->id))->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )->perMonth()
                    ->count()->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#ff0000',
                    'backgroundColor' => '#ff0000',
                ],
                [
                    'label' => 'Pending',
                    'data' => Trend::query(Appointment::where('status', '=', 'Pending')->where('doctor_id', auth()->user()->id))->between(
                        start: now()->startOfYear(),
                        end: now()->endOfYear(),
                    )->perMonth()
                    ->count()->map(fn (TrendValue $value) => $value->aggregate),
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
        return 'bar';
    }

    public static function canView(): bool
    {
        if(auth()->user()->account_level == "Administrator" || auth()->user()->account_level == "Doctor") {
            return true;
        }

        return false;
    }
}
