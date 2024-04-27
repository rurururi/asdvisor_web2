<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ParentCareDecision extends Page
{

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.parent-care-decision';

    public static function canViewAny() : bool
    {
        return auth()->user()->account_level == "Parent"; 
    }
}
