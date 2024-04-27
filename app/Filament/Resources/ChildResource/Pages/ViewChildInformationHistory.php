<?php

namespace App\Filament\Resources\ChildResource\Pages;

use App\Filament\Resources\ChildInformationHistoryResource;
use App\Filament\Resources\ChildResource;
use App\Models\ChildInformationHistory;
use App\Models\Child;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;

class ViewChildInformationHistory extends ListRecords
{
    public ?string $record = null;
    protected static string $resource = ChildInformationHistoryResource::class;
    public ?string $thisName = null;

    protected function getTableQuery(): Builder
    {
        $data = null;
        if(auth()->user()->account_level == "Parents") {
            $data = ChildInformationHistory::with(['doctor','parent','child'])->where('child_id', $this->record)->where('parent_id', auth()->user()->id);
        } else if(auth()->user()->account_level == "Doctor") {
            $data = ChildInformationHistory::with(['doctor','parent','child'])->where('child_id', $this->record)->where('doctor_id', auth()->user()->id);
        } else {
            $data = ChildInformationHistory::with(['doctor','parent','child'])->where('child_id', $this->record);
        }

        $getData = Child::where('id', $this->record ?? NULL)->first();
        if($getData) {
            self::$title = $getData->first_name . ' ' . $getData->middle_name . ' ' . $getData->last_name . ' / View Child Information History';
        } else {
            self::$title = 'View Child Stats History';
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
                ->getStateUsing( function (ChildInformationHistory $record){
                    $data = $record->child->first_name . ' ' . $record->child->middle_name . ' ' . $record->child->last_name;
                    return $data;
                }),
                Tables\Columns\TextColumn::make('behavior')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('assessment')
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
            ]);
        
    }
}
