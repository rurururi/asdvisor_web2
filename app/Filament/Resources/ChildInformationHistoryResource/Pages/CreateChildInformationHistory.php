<?php

namespace App\Filament\Resources\ChildInformationHistoryResource\Pages;

use App\Filament\Resources\ChildInformationHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateChildInformationHistory extends CreateRecord
{
    protected static bool $canCreateAnother = false;
    protected static string $resource = ChildInformationHistoryResource::class;
}
