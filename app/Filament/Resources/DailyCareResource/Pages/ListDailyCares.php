<?php

namespace App\Filament\Resources\DailyCareResource\Pages;

use App\Filament\Resources\DailyCareResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyCares extends ListRecords
{
    protected static string $resource = DailyCareResource::class;

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
