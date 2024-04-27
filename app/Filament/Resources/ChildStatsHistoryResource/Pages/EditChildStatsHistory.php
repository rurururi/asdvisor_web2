<?php

namespace App\Filament\Resources\ChildStatsHistoryResource\Pages;

use App\Filament\Resources\ChildStatsHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChildStatsHistory extends EditRecord
{
    protected static string $resource = ChildStatsHistoryResource::class;

    
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
            return "Edit Child Stats History";
        } else { 
            return "View Child Stats History";
        }
    }
}
