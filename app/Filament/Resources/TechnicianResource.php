<?php

namespace App\Filament\Resources;

use App\Constants\AppConstants;
use App\Filament\Resources\TechnicianResource\Pages;
use App\Filament\Resources\TechnicianResource\RelationManagers;
use App\Models\Technician;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TechnicianResource extends Resource
{

    protected static ?int $navigationSort = AppConstants::TechsSideMenuOrder;

    protected static ?string $model = Technician::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;

    public static function getPluralModelLabel(): string
    {
        return trans('technicians.technicians');
    }

    public static function getModelLabel(): string
    {
        return trans('technicians.technicians');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(trans('technicians.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phoneNumber')
                    ->label(trans('technicians.phoneNumber'))
                    ->tel()
                    ->telRegex('/^([4569]\d{7})$/')
                    ->prefix('+965'),
                Forms\Components\TextInput::make('password')
                    ->label(trans('technicians.password'))
                    ->password()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('technicians.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phoneNumber')
                    ->label(trans('technicians.phoneNumber'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->hidden()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->hidden()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListTechnicians::route('/'),
            'create' => Pages\CreateTechnician::route('/create'),
            'edit' => Pages\EditTechnician::route('/{record}/edit'),
        ];
    }
}
