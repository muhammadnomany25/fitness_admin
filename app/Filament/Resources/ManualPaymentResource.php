<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManualPaymentResource\Pages;
use App\Filament\Resources\ManualPaymentResource\RelationManagers;
use App\Models\ManualPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ManualPaymentResource extends Resource
{
    protected static ?string $model = ManualPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('client_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reason')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('due_date')
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('cost')
                    ->required()
                    ->numeric()
                ,
                Forms\Components\TextInput::make('order_status')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->searchable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost')
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_status')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListManualPayments::route('/'),
            'create' => Pages\CreateManualPayment::route('/create'),
            'edit' => Pages\EditManualPayment::route('/{record}/edit'),
        ];
    }
}
