<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChildStatsHistoryResource\Pages;
use App\Filament\Resources\ChildStatsHistoryResource\RelationManagers;
use App\Models\Child;
use App\Models\User;
use App\Models\ChildStatsHistory;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class ChildStatsHistoryResource extends Resource
{
    protected static ?string $model = ChildStatsHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        $schema = [];

        if(auth()->user()->account_level == "Doctor" || auth()->user()->account_level == "Parents" || auth()->user()->account_level == "Administrator") {
            $schema = [
                Select::make('doctor_id')
                ->native(false)
                ->label('Doctor')
                ->reactive()
                ->options(function(): array {
                    if(auth()->user()->account_level == "Doctor") {
                        return User::all()->where('id', auth()->user()->id)->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    } else {
                        return User::all()->where('account_level', '=', 'Doctor')->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    }
                })
                ->required()
                ->columnSpan(2),
                Select::make('parent_id')
                ->native(false)
                ->label('Parent')
                ->reactive()
                ->options(function(): array {
                    if(auth()->user()->account_level == "Parents") {
                        return User::all()->where('id', auth()->user()->id)->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    } else {
                        return User::all()->where('account_level', '=', 'Parents')->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    }
                })
                ->required()
                ->columnSpan(2),
                //
                Select::make('child_id')
                ->native(false)
                ->label('Child')
                ->reactive()
                ->options(function(callable $get): array {
                    if(auth()->user()->account_level == "Doctor") {
                        return Child::all()->where('parent_id', $get('parent_id'))->where('doctor_id', auth()->user()->id)->mapWithKeys(function ($user) {
                            return [$user->id => $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name];
                        })->toArray();
                    } else {
                        return Child::all()->where('parent_id', $get('parent_id'))->mapWithKeys(function ($user) {
                            return [$user->id => $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name];
                        })->toArray();
                    }
                })
                ->required()
                ->columnSpan(2),
                Forms\Components\TextInput::make('weight')
                    ->required()
                    ->extraAttributes(['style' => 'height: 100px'])
                    ->maxLength(255),
                Forms\Components\TextInput::make('height')
                    ->required()
                    ->extraAttributes(['style' => 'height: 100px'])
                    ->maxLength(255),
            ];  
        }

        return $form->schema($schema);
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
                //
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
                //
                Tables\Filters\TrashedFilter::make(),
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

                SelectFilter::make('child_id')
                ->label('Child')
                ->options(function(): array {
                    if(auth()->user()->account_level == "Parents") {
                        return Child::all()->where('parent_id', '=', auth()->user()->id)->mapWithKeys(function ($user) {
                            return [$user->id => $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name];
                        })->toArray();
                    } else {
                        return Child::all()->mapWithKeys(function ($user) {
                            return [$user->id => $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name];
                        })->toArray();
                    }
                }),
            ])
            ->actions(/*[
                Tables\Actions\EditAction::make(),
            ]*/$actions)
            ->bulkActions(/*[
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListChildStatsHistories::route('/'),
            'create' => Pages\CreateChildStatsHistory::route('/create'),
            'edit' => Pages\EditChildStatsHistory::route('/{record}/edit'),
            'view' => Pages\ViewChildStatsHistory::route('/{record}'),
        ];
    }

    public static function canViewAny() : bool
    {
        return auth()->user()->account_level == "Doctor" || auth()->user()->account_level == "Parents" || auth()->user()->account_level == "Administrator"; 
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->account_level == "Administrator") {
            return parent::getEloquentQuery();
        } else if(auth()->user()->account_level == "Doctor") {
            $childs = Child::where('doctor_id', auth()->user()->id)->get()->pluck('id')->toArray();
            return parent::getEloquentQuery()->whereIn('id', $childs);
        } else if(auth()->user()->account_level == "Parents") {
            $childs = Child::where('parent_id', auth()->user()->id)->get()->pluck('id')->toArray();
            return parent::getEloquentQuery()->whereIn('id', $childs);
        }
    }
}
