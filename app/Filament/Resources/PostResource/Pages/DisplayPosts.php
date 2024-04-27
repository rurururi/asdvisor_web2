<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\Page;

class DisplayPosts extends Page
{
    protected static string $resource = PostResource::class;

    public ?array $data = [];

    protected static string $view = 'filament.resources.post-resource.pages.display-posts';

}
