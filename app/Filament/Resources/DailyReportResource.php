<?php

namespace App\Filament\Resources;

use App\Constants\AppConstants;
use App\Filament\Resources\DailyReportResource\RelationManagers;
use App\Models\DailyReport;
use App\Models\Order;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\DailyReportResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class DailyReportResource extends Resource
{
    protected static ?int $navigationSort = AppConstants::DailyReportsSideMenuOrder;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $model = Order::class;
    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;
    public static function getNavigationLabel(): string
    {
        return trans('orders.daily_reports');
    }

    public static function getModelLabel(): string
    {
        return trans('orders.daily_reports');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('orders.daily_reports');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(trans('orders.id')),

                Tables\Columns\TextColumn::make('client_name')
                    ->label(trans('orders.client_name'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('client_address')
                    ->label(trans('orders.client_address')),

                Tables\Columns\TextColumn::make('client_phone')
                    ->label(trans('orders.client_phone'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label(trans('orders.status_'))
                    ->badge(),

                Tables\Columns\TextColumn::make('notes')
                    ->label(trans('orders.notes_')),

                Tables\Columns\TextColumn::make('visit_date')
                    ->label(trans('orders.visit_date'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('technician.name')
                    ->label(trans('orders.technician'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('invoice_items')
                    ->label(trans('orders.invoiceAction'))
                    ->getStateUsing(function ($record) {
                        return $record->orderInvoices->isNotEmpty() ? $record->orderInvoices->pluck('item_name')->implode(' - ') : '';
                    }),

                Tables\Columns\TextColumn::make('cost')
                    ->label(trans('invoice.total'))
                    ->getStateUsing(function ($record) {
                        $orderInvoices = $record->orderInvoices;
                        return $orderInvoices->sum(function ($invoice) {
                            return $invoice->quantity * $invoice->item_cost;
                        });
                    })

            ])
            ->filters([
                Filter::make('visit_date')
                    ->form([
                        Section::make(trans('orders.visit_date'))
                            ->schema([
                                DatePicker::make('created_from')
                                    ->label(trans('general.day')),
                            ])

                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn($query, $date) => $query->whereDate('visit_date', '=', $date));
                    }),
            ])
            ->actions([
//                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make('export')
                    ->label(trans('general.export'))
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return Order::query()
            ->where('status', 'Completed')
            ->whereDate('visit_date', Carbon::today()->toDateString())
            ->with('orderInvoices'); // Assuming 'orderInvoices' is a relationship in your Order model
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDailyReports::route('/'),
        ];
    }

}
