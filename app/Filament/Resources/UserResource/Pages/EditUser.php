<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        if(auth()->user()->account_level == "Administrator") { 
            return [
                Actions\DeleteAction::make(),
                Actions\ForceDeleteAction::make(),
                Actions\RestoreAction::make(),
            ];
        } else if(auth()->user()->account_level == "Parents") { 
            return [];
        } else if(auth()->user()->account_level == "Doctor") { 
            return [];
        }
    }

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

    public function getTitle(): string
    {
        if(auth()->user()->account_level == "Administrator") { 
            return "Edit User";
        } else if(auth()->user()->account_level == "Parents") { 
            return "View User";
        } else if(auth()->user()->account_level == "Doctor") { 
            return "View Parent";
        }
    }
}
