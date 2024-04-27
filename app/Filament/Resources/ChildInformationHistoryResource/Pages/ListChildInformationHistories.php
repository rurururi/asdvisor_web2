<?php

namespace App\Filament\Resources\ChildInformationHistoryResource\Pages;

use App\Filament\Resources\ChildInformationHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChildInformationHistories extends ListRecords
{
    protected static string $resource = ChildInformationHistoryResource::class;

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
