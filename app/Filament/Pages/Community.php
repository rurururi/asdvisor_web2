<?php

namespace App\Filament\Pages;

use Illuminate\Contracts\View\View;
use Filament\Pages\Page;

class Community extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.community';

    public function render(): View
    {
        return view('livewire.post-index');
    }
}
