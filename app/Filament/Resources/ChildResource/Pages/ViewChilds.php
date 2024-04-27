<?php

namespace App\Filament\Resources\ChildResource\Pages;

use App\Filament\Resources\ChildResource;
use App\Models\Child;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Redirect;

class ViewChilds extends ListRecords
{
    public ?string $record = null;
    protected static string $resource = ChildResource::class;

    protected function getTableQuery(): Builder
    {
        $data = Child::with(['parent'])->where('parent_id', $this->record);

        $getData = User::where('id', $this->record ?? NULL)->first();
        if($getData) {
            self::$title = $getData->name . ' / View Children';
        } else {
            self::$title = 'View Children';
        }
        return $data;
    }
    
    public function table(Table $table): Table
    {
        return $table->columns([
                Tables\Columns\TextColumn::make('child_id')
                ->label('Name')
                ->searchable()
                ->sortable()
                ->getStateUsing( function (Child $record){
                    $data = $record->first_name . ' ' . $record->middle_name . ' ' . $record->last_name;
                    return $data;
                }),
                Tables\Columns\TextColumn::make('date_of_birth')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                ->searchable()
                ->sortable(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view_child_information')
                        ->icon('heroicon-o-document')
                        ->label('Child Information History')
                        ->action(function (Child $record) {
                            Redirect::to(ChildResource::getUrl('child-information-history', ['record' => $record->id]));
                        }),
                    Tables\Actions\Action::make('view_child_informations')
                        ->icon('heroicon-o-document')
                        ->label('Child Stats History')
                        ->action(function (Child $record) {
                            Redirect::to(ChildResource::getUrl('child-stats-history', ['record' => $record->id]));
                        }),
                ])
            ]);
        
    }}
