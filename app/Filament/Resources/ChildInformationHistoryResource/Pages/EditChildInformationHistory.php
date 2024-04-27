<?php

namespace App\Filament\Resources\ChildInformationHistoryResource\Pages;

use App\Filament\Resources\ChildInformationHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChildInformationHistory extends EditRecord
{
    protected static string $resource = ChildInformationHistoryResource::class;

    protected function getHeaderActions(): array
    {
        if(auth()->user()->account_level == "Administrator") { 
            return [
            ];
        } else if(auth()->user()->account_level == "Parents") { 
            return [];
        } else if(auth()->user()->account_level == "Doctor") { 
            return [
                Actions\DeleteAction::make(),
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
        if(auth()->user()->account_level == "Doctor") { 
            return "Edit Child Information History";
        } else { 
            return "View Child Information History";
        }
    }
}
