<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorScheduleResource\Pages;
use App\Filament\Resources\DoctorScheduleResource\RelationManagers;
use App\Models\DoctorSchedule;
use App\Models\User;
use DateInterval;
use DateTime;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// Filament
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Filters\SelectFilter;

class DoctorScheduleResource extends Resource
{
    protected static ?string $model = DoctorSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        $schema = [];

        if(auth()->user()->account_level == "Administrator" || auth()->user()->account_level == "Doctor") {
            $schema = [
                Select::make('doctor_id')
                //->relationship('doctor', 'name'),
                ->label('Doctor')
                ->options(function(): array {
                    if(auth()->user()->account_level == "Doctor") {
                        return User::all()->where('id','=',auth()->user()->id)->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    } else if(auth()->user()->account_level == "Administrator") {
                        return User::all()->where('account_level','=','Doctor')->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    }
                })
                ->required(),
                Forms\Components\Select::make('weekdays')
                ->options([
                    'Monday' => 'Monday',
                    'Tuesday' => 'Tuesday',
                    'Wednesday' => 'Wednesday',
                    'Thursday' => 'Thursday',
                    'Friday' => 'Friday',
                    'Saturday' => 'Saturday',
                    'Sunday' => 'Sunday',
                ])
                ->reactive()
                ->native(false)
                ->required(),
                Forms\Components\TimePicker::make('start_time')
                    ->label('Start Time')
                    ->reactive()
                    ->required(),
                Forms\Components\TimePicker::make('end_time')
                    ->label('End Time')
                    ->reactive()
                    ->required(),
            ];
        } else if(auth()->user()->account_level == "Doctor") {
            $schema = [
                Select::make('doctor_id')
                //->relationship('doctor', 'name'),
                ->label('Doctor')
                ->options(function(): array {
                    if(auth()->user()->account_level == "Administrator") {
                        return User::all()->where('account_level','=','Doctor')->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    } else if(auth()->user()->account_level == "Doctor") {
                        return User::all()->where('id','=',auth()->user()->id)->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    }
                })
                ->required(),
                Forms\Components\Select::make('weekdays')
                ->reactive()
                ->native(false)
                ->options([
                    'Monday' => 'Monday',
                    'Tuesday' => 'Tuesday',
                    'Wednesday' => 'Wednesday',
                    'Thursday' => 'Thursday',
                    'Friday' => 'Friday',
                    'Saturday' => 'Saturday',
                    'Sunday' => 'Sunday',
                ])
                ->required(),
                Forms\Components\TimePicker::make('start_time')
                    ->label('Start Time')
                    ->reactive()
                    ->required(),
                Forms\Components\TimePicker::make('end_time')
                    ->label('End Time')
                    ->reactive()
                    ->required(),
            ];
        }
        
        return $form
            ->schema($schema);
    }

    public static function table(Table $table): Table
    {
        $actions = [];
        $bulkActions = [];
        if(auth()->user()) {
            if(auth()->user()->account_level == "Doctor") {
                $actions = [
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make()
                ];
                $bulkActions = [
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                        Tables\Actions\ForceDeleteBulkAction::make(),
                        Tables\Actions\RestoreBulkAction::make(),
                    ])
                ];
            } else {
                $actions = [
                    Tables\Actions\ViewAction::make()
                ];
            }
        }
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('doctor.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                
                    ->sortable()
                    ->getStateUsing( function (DoctorSchedule $record){
                        // Create a DateTime object from the given string
                        $dateTime = new DateTime($record->start_time);
                        $updatedTimeString = $dateTime->format('H:i:s');
                        return $updatedTimeString;
                    }),
                Tables\Columns\TextColumn::make('end_time')
                
                    ->sortable()
                    ->getStateUsing( function (DoctorSchedule $record){
                        // Create a DateTime object from the given string
                        $dateTime = new DateTime($record->end_time);
                        $updatedTimeString = $dateTime->format('H:i:s');
                        return $updatedTimeString;
                    }),
                Tables\Columns\TextColumn::make('weekdays')
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
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('doctor_id')
                ->label('Doctor')
                ->options(function(): array {
                    return User::all()->where('account_level','=','Doctor')->mapWithKeys(function ($user) {
                        return [$user->id => $user->name];
                    })->toArray();
                }),
                SelectFilter::make('weekdays')
                ->multiple()
                ->options([
                    'Monday' => 'Monday',
                    'Tuesday' => 'Tuesday',
                    'Wednesday' => 'Wednesday',
                    'Thursday' => 'Thursday',
                    'Friday' => 'Friday',
                    'Sunday' => 'Sunday',
                ])
            ])
            ->actions(/*[
                Tables\Actions\EditAction::make(),
            ]*/$actions)
            ->bulkActions(/*[
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]*/$bulkActions);
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
            'index' => Pages\ListDoctorSchedules::route('/'),
            'create' => Pages\CreateDoctorSchedule::route('/create'),
            'edit' => Pages\EditDoctorSchedule::route('/{record}/edit'),
            'view' => Pages\ViewDoctorSchedule::route('/{record}'),
        ];
    }

    public static function canViewAny() : bool
    {
        return auth()->user()->account_level == "Doctor" || auth()->user()->account_level == "Administrator"; 
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->account_level == "Administrator") {
            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        } else if(auth()->user()->account_level == "Doctor") {
            return parent::getEloquentQuery()
                ->where('doctor_id', '=', auth()->user()->id)
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        }
    }
}
