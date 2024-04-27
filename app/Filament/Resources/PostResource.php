<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Child;
use App\Models\Post;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static ?string $label = 'community';

    public static function form(Form $form): Form
    {   
        $schema = [];
        if(auth()->user()->account_level == "Parents" || auth()->user()->account_level == "Doctor" || auth()->user()->account_level == "Administrator") {
            $schema = [
                //
                Select::make('parent_id')
                ->native(false)
                ->label('Parent')
                ->reactive()
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
                })
                ->columnSpan(2)
                ->required(),
                Select::make('child_id')
                ->native(false)
                ->label('Child')
                ->reactive()
                ->options(function(callable $get) {
                    $childs = Child::where('parent_id', '=', $get('parent_id'))
                                    ->get();
                    $children = [];
                    foreach($childs as $child) {
                        $children[$child->id] = $child->first_name . ' ' . $child->middle_name . ' ' . $child->last_name;
                    }

                    return $children;
                })
                ->required()
                ->columnSpan(2),
                Forms\Components\TextInput::make('body')
                    ->required()
                    ->extraAttributes(['style' => 'height: 100px'])
                    ->maxLength(255)
                    ->columnSpan(2),
            ];
        }
        return $form->schema($schema);
    }

    public static function table(Table $table): Table
    {
        $actions = [];
        $bulkActions = [];
        if(auth()->user()->account_level == "Parents") {
            $actions = [
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
            ];
            $bulkActions = [
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ];
        } else {
            $actions = [
                Tables\Actions\ViewAction::make()
            ];
        }
        
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('parent_id')
                ->label('Parent')
                ->searchable()
                ->sortable()
                ->getStateUsing( function (Post $record){
                    $data = $record->parent->name;
                    return $data;
                }),
                Tables\Columns\TextColumn::make('child_id')
                ->label('Child')
                ->searchable()
                ->sortable()
                ->getStateUsing( function (Post $record){
                    $data = $record->child->first_name . ' ' . $record->child->middle_name . ' ' . $record->child->last_name;
                    return $data;
                }),
                Tables\Columns\TextColumn::make('body')
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
                    ->native(false)
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
                SelectFilter::make('child_id')
                    ->label('Child')
                    ->native(false)
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
                    })

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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
            'view' => Pages\ViewPost::route('/{record}'),
            // 'all' => Pages\DisplayPosts::route('/{record}'),
        ];
    }

    public static function canViewAny() : bool
    {
        // return auth()->user()->account_level == "Doctor" || auth()->user()->account_level == "Parents" || auth()->user()->account_level == "Administrator"; 
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->account_level == "Parents") {
            return parent::getEloquentQuery()->where('parent_id', auth()->user()->id);
        } else {
            return parent::getEloquentQuery();
        }
    }
}
