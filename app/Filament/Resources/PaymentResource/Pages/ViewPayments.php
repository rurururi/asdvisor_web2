<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\ChildResource;
use App\Filament\Resources\PaymentResource;
use App\Models\Appointment;
use App\Models\Child;
use App\Models\Payment;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Redirect;

class ViewPayments extends ListRecords
{
    public ?string $record = null;
    protected static string $resource = PaymentResource::class;

    protected function getTableQuery(): Builder
    {
        $newData = Payment::where('appointment_id', $this->record);

        $data = $newData->first();
        if($data) {
            self::$title = $data->appointment->appointment_date . ' - ' . $data->appointment->appointment_end_date . ' / View Payment(s)';
        } else {
            self::$title = 'View Payment(s)';
        }
        return $newData;
    }
    
    public function table(Table $table): Table
    {
        return $table->columns([
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
            ->actions([
            ]);
        
    }}
