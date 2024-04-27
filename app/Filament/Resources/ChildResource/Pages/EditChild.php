<?php

namespace App\Filament\Resources\ChildResource\Pages;

use App\Filament\Resources\ChildResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChild extends EditRecord
{
    protected static string $resource = ChildResource::class;

    protected function getHeaderActions(): array
    {
        if(auth()->user()->account_level == "Doctor") { 
            return [
                Actions\DeleteAction::make(),
            ];
        } else { 
            return [];
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
            return "Edit Child";
        } else { 
            return "View Child";
        }
    }
}
