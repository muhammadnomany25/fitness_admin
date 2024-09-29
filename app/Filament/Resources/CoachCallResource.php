<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoachCallResource\Pages;
use App\Filament\Resources\CoachCallResource\RelationManagers;
use App\Models\CoachCall;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoachCallResource extends Resource
{
    protected static ?string $model = CoachCall::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('phoneNumber')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('date')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('time')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phoneNumber')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('time')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label("Contacted")
                    ->onColor('success')
                    ->offColor('danger'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([

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
            'index' => Pages\ListCoachCalls::route('/'),
            'edit' => Pages\EditCoachCall::route('/{record}/edit'),
        ];
    }
}
