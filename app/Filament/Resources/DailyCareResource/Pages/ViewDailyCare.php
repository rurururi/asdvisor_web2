<?php

namespace App\Filament\Resources\DailyCareResource\Pages;

use App\Filament\Resources\DailyCareResource;
use App\Models\DailyCare;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Get;

class ViewDailyCare extends ViewRecord
{
    protected static string $resource = DailyCareResource::class;
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                ViewField::make('data')
                ->view('filament.forms.components.view.dailycare')
                ->formatStateUsing(function(DailyCare $record) {
                    return $record;
                })
                ->columnSpan(2),
                // Select::make('doctor_id')
                // //->relationship('doctor', 'name'),
                // ->label('Doctor')
                // ->options(function(): array {
                //     if(auth()->user()->account_level == "Doctor") {
                //         return User::all()->where('id','=',auth()->user()->id)->mapWithKeys(function ($user) {
                //             return [$user->id => $user->name];
                //         })->toArray();
                //     } else if(auth()->user()->account_level == "Administrator") {
                //         return User::all()->where('account_level','=','Doctor')->mapWithKeys(function ($user) {
                //             return [$user->id => $user->name];
                //         })->toArray();
                //     } else if(auth()->user()->account_level == "Parents") {
                //         return User::all()->where('account_level','=','Doctor')->mapWithKeys(function ($user) {
                //             return [$user->id => $user->name];
                //         })->toArray();
                //     }
                // })
                // ->columnSpan(2),
                // Forms\Components\TextInput::make('title')
                //     ->required()
                //     ->maxLength(255)
                //     ->columnSpan(2),
                // Forms\Components\TextInput::make('body')
                //     ->required()
                //     ->extraAttributes(['style' => 'height: 100px'])
                //     ->maxLength(255)
                //     ->columnSpan(2),
                // ViewField::make('image')
                //     ->view('filament.forms.components.image')
                //     ->formatStateUsing(function(Get $get) { //adds the initial state on page load
                //     return $get('image');
                // }),
            ]);
    }
}
