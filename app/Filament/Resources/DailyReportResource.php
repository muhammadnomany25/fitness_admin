<?php

namespace App\Filament\Resources;

use App\Constants\AppConstants;
use App\Filament\Resources\DailyReportResource\Pages;
use App\Filament\Resources\DailyReportResource\RelationManagers;
use App\Models\DailyReport;
use App\Models\Order;
use App\Models\OrderInvoice;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class DailyReportResource extends Resource
{
    protected static ?int $navigationSort = AppConstants::DailyReportsSideMenuOrder;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $model = Order::class;
    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;
    protected static ?string $filterDate = null;

    public static function getNavigationGroup(): ?string
    {
        return trans('general.reports_group');
    }

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

                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('orders.created_at'))
                    ->formatStateUsing(function ($state) {
                        return \Carbon\Carbon::parse($state)->format('Y-m-d');
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('invoices')
                    ->label('Invoices')
                    ->getStateUsing(function (Order $record) {
                        $invoices = OrderInvoice::where('order_id', $record->id);
                        $request = App::make('request');
                        $filterDate = $request->input('tableFilters.visit_date.created_from');
                        $input = request()->collect()->filter(function ($value) {
                            return null !== $value;
                        });
                        $input = json_decode($input, true);
                        if ($filterDate) {
                            $invoices->whereDate('created_at', $filterDate);
                        } else if ($input && json_last_error() === JSON_ERROR_NONE) {
                            if(isset($input['components'][0]['updates']['tableFilters.visit_date.created_from'])){
                                $inPageFilterDate = $input['components'][0]['updates']['tableFilters.visit_date.created_from'];
                                $invoices->whereDate('created_at', $inPageFilterDate);
                            }
                        } else {
                            $currentDate = Carbon::now()->format('Y-m-d');
                            $invoices->whereDate('created_at', $currentDate);
                        }
                        $invoiceTitles = $invoices->pluck('item_name')->toArray();
                        return implode(' - ', $invoiceTitles); // Separate invoice titles with " - "
                    }),

                Tables\Columns\TextColumn::make('cost')
                    ->label(trans('invoice.total'))
                    ->getStateUsing(function ($record) {
                        $invoices = OrderInvoice::where('order_id', $record->id);
                        $request = App::make('request');
                        $filterDate = $request->input('tableFilters.visit_date.created_from');
                        $input = request()->collect()->filter(function ($value) {
                            return null !== $value;
                        });
                        $input = json_decode($input, true);
                        if ($filterDate) {
                            $invoices->whereDate('created_at', $filterDate);
                        } else if ($input && json_last_error() === JSON_ERROR_NONE) {
                            if (isset($input['components'][0]['updates']['tableFilters.visit_date.created_from'])) {
                                $inPageFilterDate = $input['components'][0]['updates']['tableFilters.visit_date.created_from'];
                                $invoices->whereDate('created_at', $inPageFilterDate);
                            }
                        } else {
                            $currentDate = Carbon::now()->format('Y-m-d');
                            $invoices->whereDate('created_at', $currentDate);
                        }

                        // Retrieve invoice items with their calculated total (cost * quantity)
                        $invoiceItems = $invoices->get();
                        $totalAmounts = $invoiceItems->map(function ($invoice) {
                            return $invoice->item_cost * $invoice->quantity;
                        });

                        // Calculate and return the sum of total amounts
                        $totalSum = $totalAmounts->sum();

                        return number_format($totalSum, 2); // Format the sum if needed
                    })

            ])
            ->filters([
                Filter::make('visit_date')
                    ->form([
                        Section::make(trans('general.createdAt'))
                            ->schema([
                                DatePicker::make('created_from')
                                    ->label(trans('general.from'))
                                    ->native(false)
                            ])

                    ])
                    ->query(function ($query, array $data) {
                        if (isset($data['created_from']) && $data['created_from']) {
                            return $query->whereHas('orderInvoices', function (Builder $query) use ($data) {
                                $query->whereDate('created_at', $data['created_from']);
                            });
                        } else {
                            $currentDate = Carbon::now()->format('Y-m-d');
                            return $query->whereHas('orderInvoices', function (Builder $query) use ($currentDate) {
                                $query->whereDate('created_at', $currentDate);
                            });
                        }
                    }),
            ])
            ->actions([
//                Tables\Actions\ViewAction::make(),
//                new FilterAction([
//                    'label' => 'Filter by Invoice Date',
//                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make('export')
                    ->label(trans('general.export'))
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDailyReports::route('/'),
        ];
    }

}
