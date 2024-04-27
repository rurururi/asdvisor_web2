<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        if(auth()->user()->account_level == "Administrator") { 
            return [];
        } else if(auth()->user()->account_level == "Parents") { 
            return [
                Actions\DeleteAction::make(),
            ];
        } else if(auth()->user()->account_level == "Doctor") { 
            return [];
        }
    }

    protected function getFormActions(): array
    {
        if(auth()->user()->account_level == "Parents") { 
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
            return "View Post";
        } else if(auth()->user()->account_level == "Parents") { 
            return "Edit Post";
        } else if(auth()->user()->account_level == "Doctor") { 
            return "View Post";
        }
    }
}
