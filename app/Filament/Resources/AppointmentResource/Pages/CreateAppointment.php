<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord
{
    // Access Control | Step 6
    protected static bool $canCreateAnother = false;
    protected static string $resource = AppointmentResource::class;
}
