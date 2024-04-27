<?php

namespace App\Filament\Resources\ChildResource\Pages;

use App\Filament\Resources\ChildStatsHistoryResource;
use App\Filament\Resources\ChildResource;
use App\Models\Child;
use App\Models\ChildStatsHistory;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;

class ViewChildStatsHistory extends ListRecords
{
    public ?string $record = null;
    protected static string $resource = ChildStatsHistoryResource::class;
    public ?string $thisName = null;

    protected function getTableQuery(): Builder
    {
        $data = null;
        if(auth()->user()->account_level == "Parents") {
            $data = ChildStatsHistory::with(['doctor','parent','child'])->where('child_id', $this->record)->where('parent_id', auth()->user()->id);
        } else if(auth()->user()->account_level == "Doctor") {
            $data = ChildStatsHistory::with(['doctor','parent','child'])->where('child_id', $this->record)->where('doctor_id', auth()->user()->id);;
        } else {
            $data = ChildStatsHistory::with(['doctor','parent','child'])->where('child_id', $this->record);
        }
        
        $getData = Child::where('id', $this->record ?? NULL)->first();
        if($getData) {
            self::$title = $getData->first_name . ' ' . $getData->middle_name . ' ' . $getData->last_name . ' / View Child Stats History';
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
                ->getStateUsing( function (ChildStatsHistory $record){
                    $data = $record->child->first_name . ' ' . $record->child->middle_name . ' ' . $record->child->last_name;
                    return $data;
                }),
                Tables\Columns\TextColumn::make('weight')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('height')
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
