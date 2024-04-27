<?php

namespace App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;
    public function form(Form $form): Form
    {
        $schema = [
            TextInput::make('name')
            ->required(),
            TextInput::make('email')
            ->required()
            ->unique(User::class, 'email', fn($record) => $record),
            Select::make('account_level')
            ->searchable()
            ->options([
                'Administrator' => 'Administrator',
                'Doctor' => 'Doctor'
            ])
        ];
        return $form->schema($schema);
    }
}
