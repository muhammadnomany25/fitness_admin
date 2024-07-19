<?php

namespace App\Filament\Resources;

use App\Constants\AppConstants;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?int $navigationSort = AppConstants::UsersSideMenuOrder;

    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;

    public static function getNavigationGroup(): ?string
    {
        return trans('general.users_group');
    }
    public static function getPluralModelLabel(): string
    {
        return trans('users.users');
    }

    public static function getModelLabel(): string
    {
        return trans('users.users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(trans('users.name'))
                    ->required()
                    ->unique()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->unique()
                    ->label(trans('users.email'))
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->label(trans('users.password'))
                    ->password()
                    ->required()
                    ->maxLength(255),
//                Forms\Components\CheckboxList::make('roles')
//                    ->label(trans('users.roles'))
//                    ->relationship('roles', 'name')
//                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('users.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(trans('users.email'))
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn(User $record) => $record->email != 'super@akc.com'),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
