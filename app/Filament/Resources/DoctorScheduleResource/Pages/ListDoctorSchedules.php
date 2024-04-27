<?php

namespace App\Filament\Resources\DoctorScheduleResource\Pages;

use App\Filament\Resources\DoctorScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDoctorSchedules extends ListRecords
{
    protected static string $resource = DoctorScheduleResource::class;

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
