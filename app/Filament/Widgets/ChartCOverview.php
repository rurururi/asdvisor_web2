<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ChartCOverview extends ChartWidget
{
    protected static ?string $heading = 'Post/Comment(s) Chart';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $datasets = [];
        
        $datasets = [
            [
                'label' => 'Post(s)',
                'data' => Trend::model(Post::class)->between(
                    start: now()->startOfYear(),
                    end: now()->endOfYear(),
                )->perMonth()
                ->count()->map(fn (TrendValue $value) => $value->aggregate),
                'borderColor' => '#5cb85c',
                'backgroundColor' => '#5cb85c',
            ],
            [
                'label' => 'Comment(s)',
                'data' => Trend::model(Comment::class)->between(
                    start: now()->startOfYear(),
                    end: now()->endOfYear(),
                )->perMonth()
                ->count()->map(fn (TrendValue $value) => $value->aggregate),
                'borderColor' => '#ff0000',
                'backgroundColor' => '#ff0000',
            ],
        ];

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
