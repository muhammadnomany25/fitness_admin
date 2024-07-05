<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\OrderInvoice;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Query\Builder;

class OrderInvoicePage extends ManageRelatedRecords
{
    protected static ?string $model = OrderInvoicePage::class;

    protected static string $resource = OrderResource::class;

    protected static string $relationship = 'invoiceItems';

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public function getTitle(): string|Htmlable
    {
        return trans('orders.invoiceAction');
    }

    public static function getNavigationLabel(): string
    {
        return trans('orders.invoiceAction');
    }

    public static function getModelLabel(): string
    {
        return trans('orders.invoiceAction');
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item_name_en')
            ->columns([
                Tables\Columns\TextColumn::make('item_name')
                    ->label(trans('invoice.item_name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label(trans('invoice.quantity'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('item_cost')
                    ->label(trans('invoice.item_cost'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label(trans('invoice.total'))
                    ->money('kwd')
                    ->getStateUsing(function (OrderInvoice $record) {
                        return $record->quantity * $record->item_cost;
                    }),

                Tables\Columns\TextColumn::make('total_cost')
                    ->label(trans('invoice.total_cost'))
                    ->summarize(Summarizer::make()
                        ->money('kwd')
                        ->using(function (Builder $query): int {
                            return $query->selectRaw('SUM(quantity * item_cost) as total')->pluck('total')->first();
                        }))
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
//                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
