<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('appointment_id')
                ->native(false)
                ->label('Appointment (Status: Pending)')
                ->reactive()
                ->options(function(Payment $payment): array {
                    return Appointment::all()

                    ->where('status', 'Pending')
                            ->where('parent_id', auth()->user()->id)
                            ->mapWithKeys(function ($user) {
                            return [$user->id => '#'.$user->id . ' | '. $user->appointment_date . ' - ' . $user->appointment_end_date];
                    })->toArray();
                })
                ->required()
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
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required()
                    ->columnSpan(2),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('appointment_id')
                ->label('Appointment')
                ->searchable()
                ->sortable()
                ->getStateUsing( function (Payment $record){
                    $data = $record->appointment->appointment_date . ' - ' . $record->appointment->appointment_end_date;
                    return $data;
                }),

                Tables\Columns\TextColumn::make('status')
                ->label('Appointment Status')
                ->searchable()
                ->sortable()
                ->getStateUsing( function (Payment $record){
                    $data = $record->appointment->status;
                    return $data;
                }),

                Tables\Columns\TextColumn::make('amount')
                ->label('Amount')
                ->searchable()
                ->sortable()
                ->getStateUsing( function (Payment $record){
                    $data = 'P'.$record->amount;
                    return $data;
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'view' => Pages\ViewPayment::route('/{record}'),
            'payments' => Pages\ViewPayments::route('/{record}/appointment'),

            // 'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->account_level == "Parents") {
            return parent::getEloquentQuery()->where('parent_id', auth()->user()->id);
        } else if(auth()->user()->account_level == "Doctor") {
            return parent::getEloquentQuery()->where('doctor_id', auth()->user()->id);
        } else {
            return parent::getEloquentQuery();
        }
    }
}
