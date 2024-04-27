<?php

namespace App\Filament\Resources\ChildStatsHistoryResource\Pages;

use App\Filament\Resources\ChildStatsHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChildStatsHistories extends ListRecords
{
    protected static string $resource = ChildStatsHistoryResource::class;

    protected function getHeaderActions(): array
    {
        $data = [];
        if(auth()->user()) {
            if(auth()->user()->account_level == "Doctor") {
                $data = [
                    Actions\CreateAction::make(),
                ];
            }
        }
        return $data;
    }
}
