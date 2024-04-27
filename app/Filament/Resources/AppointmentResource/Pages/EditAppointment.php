<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppointment extends EditRecord
{
    protected static string $resource = AppointmentResource::class;

    // Access Control | Step 7
    protected function getHeaderActions(): array
    {
        if(auth()->user()->account_level == "Administrator") { 
            return [
                Actions\DeleteAction::make(),
            ];
        } else if(auth()->user()->account_level == "Parents") { 
            return [];
        } else if(auth()->user()->account_level == "Doctor") { 
            return [];
        }
    }

    // Access Control | Step 8
    protected function getFormActions(): array
    {
        if(auth()->user()->account_level == "Administrator") { 
            return [
                $this->getSaveFormAction(),
                $this->getCancelFormAction(),
            ];
        } else {
            return [
                $this->getCancelFormAction(),
            ];
        }
    }

    // Access Control | Step 9
    public function getTitle(): string
    {
        if(auth()->user()->account_level == "Administrator") { 
            return "Edit Appointment";
        } else if(auth()->user()->account_level == "Parents") { 
            return "View Appointment";
        } else if(auth()->user()->account_level == "Doctor") { 
            return "View Appointment";
        }
    }
}
