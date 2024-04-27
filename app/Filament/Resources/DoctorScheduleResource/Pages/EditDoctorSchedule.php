<?php

namespace App\Filament\Resources\DoctorScheduleResource\Pages;

use App\Filament\Resources\DoctorScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDoctorSchedule extends EditRecord
{
    protected static string $resource = DoctorScheduleResource::class;


    protected function getHeaderActions(): array
    {
        if(auth()->user()->account_level == "Administrator") { 
            return [];
        } else if(auth()->user()->account_level == "Parents") { 
            return [];
        } else if(auth()->user()->account_level == "Doctor") { 
            return [
                Actions\DeleteAction::make(),
                Actions\ForceDeleteAction::make(),
                Actions\RestoreAction::make(),
            ];
        }
    }

    protected function getFormActions(): array
    {
        if(auth()->user()->account_level == "Doctor") { 
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

    public function getTitle(): string
    {
        if(auth()->user()->account_level == "Administrator") { 
            return "View Doctor Schedule";
        } else if(auth()->user()->account_level == "Parents") { 
            return "View Doctor Schedule";
        } else if(auth()->user()->account_level == "Doctor") { 
            return "Edit Doctor Schedule";
        }
    }
}
