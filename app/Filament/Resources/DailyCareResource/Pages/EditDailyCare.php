<?php

namespace App\Filament\Resources\DailyCareResource\Pages;

use App\Filament\Resources\DailyCareResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDailyCare extends EditRecord
{
    protected static string $resource = DailyCareResource::class;

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
            return "View Daily Care";
        } else if(auth()->user()->account_level == "Parents") { 
            return "View Daily Care";
        } else if(auth()->user()->account_level == "Doctor") { 
            return "Edit Daily Care";
        }
    }
}
