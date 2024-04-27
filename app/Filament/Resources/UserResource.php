<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
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
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Hidden;
use Illuminate\Support\Facades\Redirect;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        $schema = [];

        if(auth()->user()->account_level == "Administrator") {
            $schema = [
                //
                static::getNameFormField(),
                static::getEmailFormField(),
                static::getAccountLevelFormField(),
                TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                ->required(),
                Hidden::make('email_verified_at')
                ->default(now()->endOfDay())
                ->required()
            ];
        } else if(auth()->user()->account_level == "Doctor") {
            $schema = [
                //
                static::getNameFormField(),
                static::getEmailFormField(),
                static::getAccountLevelFormField()
            ];
        }
        return $form->schema($schema);
    }

    public static function table(Table $table): Table
    {
        $actions = [];
        $bulkActions = [];
        $filters = [
            Tables\Filters\TrashedFilter::make()
        ];
        if(auth()->user()) {
            if(auth()->user()->account_level == "Administrator") {
                $actions = [
                    Tables\Actions\ActionGroup::make([
                        Tables\Actions\EditAction::make(),
                        Tables\Actions\ViewAction::make(),
                        Tables\Actions\Action::make('view_childs')
                        ->icon('heroicon-o-document')
                        ->label('View Children')
                        ->action(function (User $record) {
                            Redirect::to(ChildResource::getUrl('view-childs', ['record' => $record->id]));
                        })
                        ->visible(fn (User $record): bool => $record->account_level == "Parents")


                    ])
                ];

                $bulkActions = [
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                        Tables\Actions\ForceDeleteBulkAction::make(),
                        Tables\Actions\RestoreBulkAction::make(),
                    ]),
                ];

                $filters[] = SelectFilter::make('account_level')
                            ->options([
                                'Administrator' => 'Administrator',
                                'Doctor' => 'Doctor',
                            ]);
            } else if(auth()->user()->account_level == "Doctor") {
                $actions = [
                    Tables\Actions\ActionGroup::make([
                        Tables\Actions\ViewAction::make(),
                        Tables\Actions\Action::make('view_childs')
                        ->icon('heroicon-o-document')
                        ->label('View Children')
                        ->action(function (User $record) {
                            Redirect::to(ChildResource::getUrl('view-childs', ['record' => $record->id]));
                        })
                        ->visible(fn (User $record): bool => $record->account_level == "Parents")
                    ])
                ];
            }
        }
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                ->searchable(),
                Tables\Columns\TextColumn::make('email')
                ->searchable(),
                Tables\Columns\TextColumn::make('account_level')
                ->searchable(),
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
            ->filters($filters)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
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
                ->where('account_level','=','Parents')
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        } else {
            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        }
    }

    // Forms
    public static function getNameFormField(): Forms\Components\TextInput
    {
        return TextInput::make('name')
            ->required();
    }

    public static function getEmailFormField(): Forms\Components\TextInput
    {
        return TextInput::make('email')
            ->required()
            ->unique(User::class, 'email', fn($record) => $record);
    }

    public static function getAccountLevelFormField()
    {
        return Select::make('account_level')
        ->searchable()
        ->options([
            'Administrator' => 'Administrator',
            'Doctor' => 'Doctor'
        ]);
    }
}
