<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        $data = [];
        if(auth()->user()) {
            if(auth()->user()->account_level == "Parents") {
                $data = [
                    Actions\CreateAction::make(),
                ];
            }
        }
        return $data;
    }
}
