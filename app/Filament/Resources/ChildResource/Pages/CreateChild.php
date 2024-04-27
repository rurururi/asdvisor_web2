<?php

namespace App\Filament\Resources\ChildResource\Pages;

use App\Filament\Resources\ChildResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateChild extends CreateRecord
{
    protected static bool $canCreateAnother = false;
    protected static string $resource = ChildResource::class;
}
