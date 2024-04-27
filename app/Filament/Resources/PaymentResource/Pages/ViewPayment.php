<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Get;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\ImageEntry;

class ViewPayment extends ViewRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('appointment_id')
                ->native(false)
                ->label('Appointment (Status: Pending)')
                ->reactive()
                ->options(function(Payment $payment): array {
                    return Appointment::all()

                            ->where('parent_id', auth()->user()->id)
                            ->mapWithKeys(function ($user) {
                            return [$user->id => '#'.$user->id . ' | '. $user->appointment_date . ' - ' . $user->appointment_end_date];
                    })->toArray();
                })
                ->columnSpan(2),
                Select::make('parent_id')
                ->native(false)
                ->label('Parent')
                ->reactive()
                ->options(function(callable $get): array {
                    $appointment = Appointment::where('id', $get('appointment_id'))->first();
                    return User::all()->where('id', $appointment->parent_id ?? NULL)->mapWithKeys(function ($user) {
                        return [$user->id => $user->name];
                    })->toArray();
                })
                ->required()
                ->columnSpan(2),
                
                Select::make('doctor_id')
                ->native(false)
                ->label('Doctor')
                ->reactive()
                ->options(function(callable $get): array {
                    $appointment = Appointment::where('id', $get('appointment_id'))->first();
                    return User::all()->where('id', $appointment->doctor_id ?? NULL)->mapWithKeys(function ($user) {
                        return [$user->id => $user->name];
                    })->toArray();
                })
                ->columnSpan(2)
                ->required(),
                ViewField::make('image')
                    ->view('filament.forms.components.image')
                    ->formatStateUsing(function(Get $get) { //adds the initial state on page load
                    return $get('image');
                }),
                Forms\Components\TextInput::make('ref_no')
                    ->label('Reference Number #')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
            ]);
    }
}
