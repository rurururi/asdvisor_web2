<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Filament\Resources\AppointmentResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class ViewAppointment extends ViewRecord
{
    protected static string $resource = AppointmentResource::class;
    public function form(Form $form): Form
    {
        $schema = [
            Select::make('doctor_id')
                ->label('Doctor')
                ->native(false)
                ->lazy()
                ->options(function(): array {
                    if(auth()->user()->account_level == "Administrator" ||  auth()->user()->account_level == "Parents") {
                        return User::all()->where('account_level','=','Doctor')->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    } else if(auth()->user()->account_level == "Doctor") {
                        return User::all()->where('account_level','=','Doctor')->where('id', auth()->user()->id)->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    }
                }),
            Select::make('parent_id')
                ->lazy()
                ->native(false)
                ->label('Parent')
                ->options(function(): array {
                    if(auth()->user()->account_level == "Doctor") {
                        return User::all()->where('account_level','=','Parents')->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    } else if(auth()->user()->account_level == "Parents") {
                        return User::all()
                                ->where('account_level','=','Parents')
                                ->where('id', '=', auth()->user()->id)
                                ->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    }
                }),
            TextInput::make('appointment_date')
                ->readOnly(),
            TextInput::make('appointment_end_date')
                ->readOnly(),
            Select::make('status')
                //->relationship('doctor', 'name'),
                ->label('Status')
                ->native(false)
                ->lazy()
                ->options([
                    'Pending' => 'Pending',
                    'Approved' => 'Approved',
                    'Rejected' => 'Rejected'
                ])
        ];
        return $form->schema($schema);
    }
}
