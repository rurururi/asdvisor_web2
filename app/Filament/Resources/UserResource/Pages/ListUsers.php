<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        $data = [];
        if(auth()->user()) {
            if(auth()->user()->account_level == "Administrator") {
                $data = [
                    Actions\CreateAction::make(),
                ];
            }
        }
        return $data;
    }
}
