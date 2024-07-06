<?php

namespace App\Filament\Resources;

use App\Constants\AppConstants;
use App\Filament\Resources\ManualPaymentResource\Pages;
use App\Filament\Resources\ManualPaymentResource\RelationManagers;
use App\Models\ManualPayment;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ManualPaymentResource extends Resource
{
    protected static ?int $navigationSort = AppConstants::DuePaymentsSideMenuOrder;

    protected static ?string $model = ManualPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return trans('general.reports_group');
    }

    public static function getNavigationLabel(): string
    {
        return trans('invoice.due_payments');

    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereDate('due_date', Carbon::today())->count();
    }


    public static function getModelLabel(): string
    {
        return trans('invoice.due_payments');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('invoice.due_payments');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('client_name')
                    ->label(trans('due_payments.client_name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reason')
                    ->label(trans('due_payments.reason'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('due_date')
                    ->label(trans('due_payments.due_date'))
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('cost')
                    ->label(trans('due_payments.cost'))
                    ->required()
                    ->numeric()
                ,
                Forms\Components\TextInput::make('order_status')
                    ->label(trans('due_payments.order_status'))
                    ->maxLength(255)
                    ->default(null),

                Forms\Components\Textarea::make('notes')
                    ->label(trans('due_payments.notes'))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client_name')
                    ->label(trans('due_payments.client_name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label(trans('due_payments.reason'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label(trans('due_payments.due_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost')
                    ->label(trans('due_payments.cost'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('order_status')
                    ->label(trans('due_payments.order_status'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('notes')
                    ->label(trans('due_payments.notes'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make('export')
                    ->label(trans('general.export'))
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
