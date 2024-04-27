<?php

namespace App\Filament\Resources\DailyCareResource\Pages;

use App\Filament\Resources\DailyCareResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDailyCare extends CreateRecord
{
    protected static bool $canCreateAnother = false;
    protected static string $resource = DailyCareResource::class;
}
