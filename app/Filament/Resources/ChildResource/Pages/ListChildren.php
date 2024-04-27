<?php

namespace App\Filament\Resources\ChildResource\Pages;

use App\Filament\Resources\ChildResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChildren extends ListRecords
{
    protected static string $resource = ChildResource::class;

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
