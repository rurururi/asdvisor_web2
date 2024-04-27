<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChildResource\Pages;
use App\Filament\Resources\ChildResource\RelationManagers;
use App\Models\Child;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Redirect;

class ChildResource extends Resource
{
    protected static ?string $model = Child::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        $schema = [];
        $autoSelectDoctor = auth()->user()->account_level == "Doctor" ? auth()->user()->id : "";

        if(auth()->user()->account_level == "Doctor" || auth()->user()->account_level == "Parents" || auth()->user()->account_level == "Administrator") {
            $schema = [
                //
                Select::make('parent_id')
                ->native(false)
                ->label('Parent')
                ->options(function(): array {
                    if(auth()->user()->account_level == "Doctor" || auth()->user()->account_level == "Administrator") {
                        return User::all()->where('account_level','=','Parents')->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    } else if(auth()->user()->account_level == "Parents") {
                        return User::all()->where('id','=',auth()->user()->id)->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    }
                })
                ->required(),
                Select::make('doctor_id')
                ->native(false)
                ->label('Doctor')
                ->options(function(): array {
                    if(auth()->user()->account_level == "Doctor") {
                        return User::all()->where('id','=',auth()->user()->id)->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    } else {
                        return User::all()->where('account_level','=','Doctor')->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    } 
                })
                ->default($autoSelectDoctor)
                ->required(),
                TextInput::make('first_name')
                ->required(),
                TextInput::make('middle_name')
                ->required(),
                TextInput::make('last_name')
                ->required(),
                DatePicker::make('date_of_birth')
                ->minDate('01-01-1900')
                ->maxDate(now()->endOfDay())
                ->native(false)
                ->required()
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
                    Tables\Actions\ViewAction::make(),
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
                ];
                $bulkActions = [
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
                ];
            } else {
                $actions = [
                    Tables\Actions\ActionGroup::make([
                        Tables\Actions\ViewAction::make()->label('View data'),
                        Tables\Actions\Action::make('view_child_information')
                            ->icon('heroicon-o-document')
                            ->label('Child Information History')
                            ->action(function (Child $record) {
                                Redirect::to(ChildResource::getUrl('child-information-history', ['record' => $record->id]));
                            }),
                        Tables\Actions\Action::make('view_child_information')
                            ->icon('heroicon-o-document')
                            ->label('Child Stats History')
                            ->action(function (Child $record) {
                                Redirect::to(ChildResource::getUrl('child-stats-history', ['record' => $record->id]));
                            }),
                    ])
                ];
            }
        }
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('middle_name')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('last_name')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('date_of_birth')
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
                        return User::all()->where('id','=',auth()->user()->id)->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    } else {
                        return User::all()->where('account_level','=','Parents')->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
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
            'index' => Pages\ListChildren::route('/'),
            'create' => Pages\CreateChild::route('/create'),
            'edit' => Pages\EditChild::route('/{record}/edit'),
            'view' => Pages\ViewChild::route('/{record}'),
            'child-information-history' => Pages\ViewChildInformationHistory::route('/{record}/child-information'),
            'child-stats-history' => Pages\ViewChildStatsHistory::route('/{record}/child-stats'),
            'view-childs' => Pages\ViewChilds::route('/{record}/view-childs'),
            //'child-stats-history' => Pages\ViewChildStatsHistory::route('{record}/child-stats')
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
            return parent::getEloquentQuery()->where('doctor_id', auth()->user()->id);
        } else if(auth()->user()->account_level == "Parents") {
            $childs = Child::where('parent_id', auth()->user()->id)->get()->pluck('id')->toArray();
            return parent::getEloquentQuery()->whereIn('id', $childs);
        }
    }
}
