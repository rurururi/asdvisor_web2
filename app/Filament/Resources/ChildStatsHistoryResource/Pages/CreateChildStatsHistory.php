<?php

namespace App\Filament\Resources\ChildStatsHistoryResource\Pages;

use App\Filament\Resources\ChildStatsHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateChildStatsHistory extends CreateRecord
{
    protected static bool $canCreateAnother = false;
    protected static string $resource = ChildStatsHistoryResource::class;
}
