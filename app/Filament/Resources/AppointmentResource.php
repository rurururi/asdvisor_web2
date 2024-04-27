<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Set;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateInterval;
use DateTime;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Redirect;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    // Access Control | Step 1
    public static function form(Form $form): Form
    {
        $schema = [];
        if(auth()->user()->account_level == "Parents" ) {
            $schema = [
                //
                Select::make('doctor_id')
                //->relationship('doctor', 'name'),
                ->label('Doctor')
                ->native(false)
                ->lazy()
                ->options(function(): array {
                    return User::all()->where('account_level','=','Doctor')->mapWithKeys(function ($user) {
                        return [$user->id => $user->name];
                    })->toArray();
                }),
                Select::make('parent_id')
                    //->relationship('doctor', 'name'),
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
                    })
                    ->default(auth()->user()->id),
                Forms\Components\DatePicker::make('date')
                    ->native(false)
                    //->relationship('doctor', 'name'),
                    ->label('Available Date')
                    ->lazy()
                    ->minDate(now())
                    ->maxDate(now()->endOfYear())
                    ->disabledDates(function (callable $get) { 
                        
                        $getData = DoctorSchedule::select('weekdays')->where('doctor_id', $get('doctor_id'))->get();
                        $getWeeks = [];
                        if($getData) {
                            
                            foreach($getData as $data) {
                                $getWeeks[] = Carbon::parse($data->weekdays)->dayOfWeek;
                            }
                        }
                        
                        $start = Carbon::now()->startOfMonth();
                        $end = $start->copy()->endOfYear();
                        $period = CarbonPeriod::create($start, $end)->filter(function (Carbon $date) use ($getWeeks) {
                            return !in_array($date->dayOfWeek, $getWeeks);
                        });

                        $weekends = [];
                        foreach ($period as $date) {
                            $weekends[] = $date->format('Y-m-d');
                        }

                        return $weekends;
                    })
                    ->required(),
                // Select::make('appointment_date')
                //     ->label('Time')
                //     ->native(false)
                //     ->reactive()
                //     ->options(function(callable $get) {
                //         $getDate = explode(" ", $get('date'));
                //         $array = [
                //             '07:00:00',
                //             '08:00:00',
                //             '09:00:00',
                //             '10:00:00',
                //             '14:00:00',
                //             '15:00:00',
                //             '16:00:00',
                //             '17:00:00'
                //         ];
                        
                //         $getMyDate = [];
                //         foreach($array as $data) {
                //             $dateTime =  new DateTime($getDate[0] . ' ' .$data);
                //             $checking = DoctorSchedule::select('weekdays')
                //                         ->where('doctor_id', $get('doctor_id'))
                //                         ->where('start_time', date_format($dateTime, "Y-m-d H:i:s"))
                //                         ->where('weekdays', Carbon::parse(date_format($dateTime, "Y-m-d H:i:s"))->englishDayOfWeek)
                //                         ->first();

                //             if($checking) {
                                        
                //                 $appointment = Appointment::where('appointment_date', '=', date_format($dateTime, "Y-m-d H:i:s"))
                //                             ->where('doctor_id', '=', $get('doctor_id'))
                //                             ->first();

                //                 // Add 1 hour to the DateTime object
                //                 $dateTime->add(new DateInterval('PT1H'));

                //                 // Format the updated DateTime object as a string
                //                 $updatedTimeString = $dateTime->format('H:i:s');
                //                 if(!$appointment) {
                //                     $getMyDate[date_format($dateTime, "Y-m-d H:i:s")] = (string) $data . ' - ' . $updatedTimeString;
                //                 }
                //             }
                //         }

                //         return $getMyDate;
                //     })
                //     ->required()
                Select::make('appointment_date_time')
                ->make('Available Time')
                ->native(false)
                ->reactive()
                ->options(function(callable $get) {
                    if($get('date')) {
                        $getMyDate = [];
                        $dateString = $get('date');
                        $timestamp = strtotime($dateString);
                        $weekday = date("l", $timestamp);
                        $checkings = DoctorSchedule::where('doctor_id', $get('doctor_id'))
                                    ->where('weekdays', $weekday)
                                    ->get();

                        foreach($checkings as $checking) {
                            // Get selected date time 
                            $time =  new DateTime($dateString);
                            $timeString = $time->format('Y-m-d');

                            // Get Start time
                            $startTimeString = $checking->start_time;
                            // Get End Time
                            $endTimeString = $checking->end_time;

                            $startDateTime =  new DateTime($timeString . ' ' .$startTimeString);
                            $startDateTimeString = $startDateTime->format('H:i:s');

                            $endDateTime =  new DateTime($timeString . ' ' .$endTimeString);
                            $endDateTimeString = $endDateTime->format('H:i:s');

                            $appointment = Appointment::where('appointment_date', '=', $startDateTime)
                                                        ->where('appointment_end_date', '=', $endDateTime)
                                                        ->where('doctor_id', '=', $get('doctor_id'))
                                                        ->where('status', '=', 'Approved')
                                                        ->first();
                            if(!$appointment) {
                                $getMyDate[$startDateTimeString . ';' . $endDateTimeString] = (string) $startDateTimeString . ' - ' . $endDateTimeString;
                            }

                            return $getMyDate;
                        }
                        return [];
                    }
                })
                ->afterStateUpdated(function (Set $set, callable $get, $state) {
                    if($state) {
                        $date =  new DateTime($get('date'));
                        $dateString = $date->format('Y-m-d');

                        $explode = explode(';', $state);
                        $set('appointment_date', $dateString . ' ' . $explode[0]);
                        $set('appointment_end_date', $dateString . ' ' . $explode[1]);
                    }
                }),
                TextInput::make('appointment_date')
                ->reactive()
                ->readOnly(),
                TextInput::make('appointment_end_date')
                ->reactive()
                ->readOnly()
            ];
        } else if(auth()->user()->account_level == "Doctor" || auth()->user()->account_level == "Administrator") {
            $schema = [
                //
                Select::make('doctor_id')
                //->relationship('doctor', 'name'),
                ->label('Doctor')
                ->native(false)
                ->lazy()
                ->options(function(): array {
                    if(auth()->user()->account_level == "Administrator") {
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
                    //->relationship('doctor', 'name'),
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
                    })
                    ->default(auth()->user()->id),
                Forms\Components\DatePicker::make('date')
                    ->native(false)
                    //->relationship('doctor', 'name'),
                    ->label('Date')
                    ->lazy()
                    ->minDate(now())
                    ->maxDate(now()->endOfYear())
                    ->disabledDates(function (callable $get) { 
                        
                        $getData = DoctorSchedule::select('weekdays')->where('doctor_id', $get('doctor_id'))->get();
                        $getWeeks = [];
                        if($getData) {
                            
                            foreach($getData as $data) {
                                $getWeeks[] = Carbon::parse($data->weekdays)->dayOfWeek;
                            }
                        }
                        
                        $start = Carbon::now()->startOfMonth();
                        $end = $start->copy()->endOfYear();
                        $period = CarbonPeriod::create($start, $end)->filter(function (Carbon $date) use ($getWeeks) {
                            return !in_array($date->dayOfWeek, $getWeeks);
                        });

                        $weekends = [];
                        foreach ($period as $date) {
                            $weekends[] = $date->format('Y-m-d');
                        }

                        return $weekends;
                    })
                    ->required(),
                // Select::make('appointment_date')
                //     ->label('Time')
                //     ->native(false)
                //     ->lazy()
                //     ->options(function(callable $get) {
                //         $getDate = explode(" ", $get('date'));
                //         $array = [
                //             '07:00:00',
                //             '08:00:00',
                //             '09:00:00',
                //             '10:00:00',
                //             '14:00:00',
                //             '15:00:00',
                //             '16:00:00',
                //             '17:00:00'
                //         ];
                        
                //         $getMyDate = [];
                //         foreach($array as $data) {
                //             $dateTime =  new DateTime($getDate[0] . ' ' .$data);

                //             $checking = DoctorSchedule::select('weekdays')
                //                         ->where('doctor_id', $get('doctor_id'))
                //                         ->where('start_time', date_format($dateTime, "Y-m-d H:i:s"))
                //                         ->where('weekdays', Carbon::parse(date_format($dateTime, "Y-m-d H:i:s"))->englishDayOfWeek)
                //                         ->first();

                //             if($checking) {
                                        
                //                 $appointment = Appointment::where('appointment_date', '=', date_format($dateTime, "Y-m-d H:i:s"))
                //                             ->where('doctor_id', '=', $get('doctor_id'))
                //                             ->first();

                //                 // Add 1 hour to the DateTime object
                //                 $dateTime->add(new DateInterval('PT1H'));

                //                 // Format the updated DateTime object as a string
                //                 $updatedTimeString = $dateTime->format('H:i:s');
                //                 if(!$appointment) {
                //                     $getMyDate[date_format($dateTime, "Y-m-d H:i:s")] = (string) $data . ' - ' . $updatedTimeString;
                //                 }
                //             }
                //         }

                //         return $getMyDate;
                //     })
                //     ->required(),
                Select::make('appointment_date_time')
                ->make('Available Time')
                ->native(false)
                ->reactive()
                ->options(function(callable $get) {
                    if($get('date')) {
                        $getMyDate = [];
                        $dateString = $get('date');
                        $timestamp = strtotime($dateString);
                        $weekday = date("l", $timestamp);
                        $checkings = DoctorSchedule::where('doctor_id', $get('doctor_id'))
                                    ->where('weekdays', $weekday)
                                    ->get();

                        foreach($checkings as $checking) {
                            // Get selected date time 
                            $time =  new DateTime($dateString);
                            $timeString = $time->format('Y-m-d');

                            // Get Start time
                            $startTimeString = $checking->start_time;
                            // Get End Time
                            $endTimeString = $checking->end_time;

                            $startDateTime =  new DateTime($timeString . ' ' .$startTimeString);
                            $startDateTimeString = $startDateTime->format('H:i:s');

                            $endDateTime =  new DateTime($timeString . ' ' .$endTimeString);
                            $endDateTimeString = $endDateTime->format('H:i:s');

                            $appointment = Appointment::where('appointment_date', '=', $startDateTime)
                                                        ->where('appointment_end_date', '=', $endDateTime)
                                                        ->where('doctor_id', '=', $get('doctor_id'))
                                                        ->where('status', '=', 'Approved')
                                                        ->first();
                            if(!$appointment) {
                                $getMyDate[$startDateTimeString . ';' . $endDateTimeString] = (string) $startDateTimeString . ' - ' . $endDateTimeString;
                            }

                            return $getMyDate;
                        }
                        return [];
                    }
                })
                ->afterStateUpdated(function (Set $set, callable $get, $state) {
                    if($state) {
                        $date =  new DateTime($get('date'));
                        $dateString = $date->format('Y-m-d');

                        $explode = explode(';', $state);
                        $set('appointment_date', $dateString . ' ' . $explode[0]);
                        $set('appointment_end_date', $dateString . ' ' . $explode[1]);
                    }
                }),
                TextInput::make('appointment_date')
                ->reactive()
                ->readOnly(),
                TextInput::make('appointment_end_date')
                ->reactive()
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
        }
        return $form->schema($schema);
    }

    public static function table(Table $table): Table
    {
        // Access Control | Step 2
        $actions = [];
        $bulkActions = [];
        if(auth()->user()) {
            if(auth()->user()->account_level == "Doctor") {
                $actions = [
                    //Tables\Actions\EditAction::make(),
                    Action::make('approved')
                    ->label('Approved')
                    ->action(function (Appointment $record) {
                        if($record->status == 'Pending') {
                            $record->status = 'Approved';
                            $record->save();
                            Notification::make()
                            ->title('Successfully!')
                            ->success()
                            ->send();
                        } else {
                            Notification::make()
                            ->title('Error! That appointment is already set!')
                            ->icon('heroicon-o-x-mark')
                            ->send();
                        }
                    }),
                    Action::make('rejected')
                    ->label('Rejected')
                    ->action(function (Appointment $record) {
                        if($record->status == 'Pending') {
                            $record->status = 'Rejected';
                            $record->save();
                            Notification::make()
                            ->title('Successfully!')
                            ->success()
                            ->send();
                        } else {
                            Notification::make()
                            ->title('Error! That appointment is already set!')
                            ->icon('heroicon-o-x-mark')
                            ->send();
                        }
                    }),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\ActionGroup::make([
                        Tables\Actions\Action::make('view-payments')
                            ->icon('heroicon-o-document')
                            ->label('View payment(s)')
                            ->action(function (Appointment $record) {
                                Redirect::to(PaymentResource::getUrl('payments', ['record' => $record->id]));
                            }),
                    ])
                ];
            } else if(auth()->user()->account_level == "Parents") {
                $actions = [
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('payment')
                            ->icon('heroicon-o-document')
                            ->label('Pay now!')
                            ->action(function (Appointment $record) {
                                Redirect::to(PaymentResource::getUrl('create', []));
                            }),
                ];
                $bulkActions = [
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ])
                ];
            } else {
                $actions = [
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\ActionGroup::make([
                        Tables\Actions\Action::make('view-payments')
                            ->icon('heroicon-o-document')
                            ->label('View payment(s)')
                            ->action(function (Appointment $record) {
                                Redirect::to(PaymentResource::getUrl('payments', ['record' => $record->id]));
                            }),
                    ])
                ];
            }
        }

        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('doctor.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('appointment_date')
                    ->label('Start Time')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing( function (Appointment $record){
                        // Create a DateTime object from the given string
                        $dateTime = new DateTime($record->appointment_date);
                        // Add 1 hour to the DateTime object
                        $updatedTimeString = $dateTime->format('M d, Y H:i:s');
                        return $updatedTimeString;
                }),
                Tables\Columns\TextColumn::make('ending')
                    ->label('End Time')
                    ->getStateUsing( function (Appointment $record){
                        // Create a DateTime object from the given string
                        $dateTime = new DateTime($record->appointment_date);
                        // Add 1 hour to the DateTime object
                        $dateTime->add(new DateInterval('PT1H'));
                        $updatedTimeString = $dateTime->format('M d, Y H:i:s');
                        return $updatedTimeString;
                }),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Access Control | Step 3
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('doctor_id')
                    ->label('Doctor')
                    ->options(function(): array {
                        return User::all()->where('account_level','=','Doctor')->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    }),
                SelectFilter::make('parent_id')
                    ->label('Parent')
                    ->options(function(): array {
                        if(auth()->user()->account_level == "Parents") {
                            return User::all()->where('id','=', auth()->user()->id)->mapWithKeys(function ($user) {
                                return [$user->id => $user->name];
                            })->toArray();
                        } else {
                            return User::all()->where('account_level','=','Parents')->mapWithKeys(function ($user) {
                                return [$user->id => $user->name];
                            })->toArray();
                        }
                    }),
            ])
            ->actions($actions)
            ->bulkActions($bulkActions);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
            'view' => Pages\ViewAppointment::route('/{record}'),
        ];
    }

    // Access Control | Step 4
    public static function canViewAny() : bool
    {
        return auth()->user()->account_level == "Doctor" || auth()->user()->account_level == "Parents" || auth()->user()->account_level == "Administrator"; 
    }

    // Access Control | Step 5
    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->account_level == "Administrator") {
            return parent::getEloquentQuery();
        } else if(auth()->user()->account_level == "Doctor") {
            return parent::getEloquentQuery()->where('doctor_id', auth()->user()->id);
        } else if(auth()->user()->account_level == "Parents") {
            return parent::getEloquentQuery()->where('parent_id', auth()->user()->id);
        }
    }
}
