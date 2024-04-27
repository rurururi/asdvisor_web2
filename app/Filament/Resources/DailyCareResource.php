<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyCareResource\Pages;
use App\Filament\Resources\DailyCareResource\RelationManagers;
use App\Models\DailyCare;
use App\Models\User;
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

class DailyCareResource extends Resource
{
    protected static ?string $model = DailyCare::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        $schema = [];

        if(auth()->user()->account_level == "Doctor" || auth()->user()->account_level == "Administrator" || auth()->user()->account_level == "Parents") {
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
                    } else if(auth()->user()->account_level == "Parents") {
                        return User::all()->where('account_level','=','Doctor')->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    }
                })
                ->columnSpan(2),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\TextInput::make('body')
                    ->required()
                    ->extraAttributes(['style' => 'height: 100px'])
                    ->maxLength(255)
                    ->columnSpan(2),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required()
                    ->columnSpan(2),
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
                        Tables\Actions\ForceDeleteBulkAction::make(),
                        Tables\Actions\RestoreBulkAction::make(),
                    ]),
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
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
                    if(auth()->user()->account_level == "Doctor") {
                        return User::all()->where('id','=', auth()->user()->id)->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    } else {
                        return User::all()->where('account_level','=','Doctor')->mapWithKeys(function ($user) {
                            return [$user->id => $user->name];
                        })->toArray();
                    }
                })
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
            'index' => Pages\ListDailyCares::route('/'),
            'create' => Pages\CreateDailyCare::route('/create'),
            'edit' => Pages\EditDailyCare::route('/{record}/edit'),
            'view' => Pages\ViewDailyCare::route('/{record}'),
        ];
    }

    // Search
    public static function getGloballySearchableAttributes(): array
    {
        return ['doctor.name', 'title', 'body'];
    }

    public static function canViewAny() : bool
    {
        return auth()->user()->account_level == "Doctor" || auth()->user()->account_level == "Parents" || auth()->user()->account_level == "Administrator"; 
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->account_level == "Administrator") {
            return parent::getEloquentQuery()->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
        } else if(auth()->user()->account_level == "Doctor") {
            return parent::getEloquentQuery()->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])->where('doctor_id', auth()->user()->id);
        } else if(auth()->user()->account_level == "Parents") {
            return parent::getEloquentQuery()->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
        }
    }
}
