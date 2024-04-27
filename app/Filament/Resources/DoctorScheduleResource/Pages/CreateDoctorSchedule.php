<?php

namespace App\Filament\Resources\DoctorScheduleResource\Pages;

use App\Filament\Resources\DoctorScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateDoctorSchedule extends CreateRecord
{
    protected static string $resource = DoctorScheduleResource::class;
    
    protected static bool $canCreateAnother = false;
    protected function handleRecordCreation(array $data): Model
    {
        $check = static::getModel()::where($data)->first();

        if(!$check) {
            $model = static::getModel()::create($data);
            return $model;
        }
        
        
        return $check;
    }
}
