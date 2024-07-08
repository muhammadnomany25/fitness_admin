<?php

namespace App\Filament\Resources;

use App\Constants\AppConstants;
use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Services\FCMService;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class OrderResource extends Resource
{

    protected static ?int $navigationSort = AppConstants::OrdersSideMenuOrder;

    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getNavigationGroup(): ?string
    {
        return trans('general.orders_group');
    }

    protected static ?string $modelLabel = null;
    protected static ?string $pluralModelLabel = null;

    public static function getPluralModelLabel(): string
    {
        return trans('orders.orders_');
    }

    public static function getModelLabel(): string
    {
        return trans('orders.order_');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columnSpan(2)
                    ->schema([
                        Forms\Components\ToggleButtons::make('status')
                            ->label(trans('orders.status_'))
                            ->inline()
                            ->options(OrderStatus::class)
                            ->default(OrderStatus::New->value)
                            ->required()
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('client_name')
                            ->required()
                            ->label(trans('orders.client_name'))
                            ->maxLength(255),

                        Forms\Components\TextInput::make('client_phone')
                            ->tel()
                            ->string()
                            ->telRegex('/^([4569]\d{7})$/')
                            ->prefix('+965')
                            ->label(trans('orders.client_phone'))
                            ->required()
                            ->columnSpan(2)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('client_address')
                            ->required()
                            ->label(trans('orders.client_address'))
                            ->maxLength(255),

                        Select::make('technician_id')
                            ->relationship(name: 'technician', titleAttribute: 'name')
                            ->searchable()
                            ->label(trans('orders.technician'))
                            ->preload()
                            ->columnSpan(2),

//                        Datepicker::make('visit_date')->label('Visit Date')->nullable(),

                        Select::make('user_id')
                            ->label(trans('orders.order_creator'))
                            ->options([
                                Auth::id() => Auth::user()->name,
                            ])
                            ->preload()
                            ->default(Auth::id())
                            ->required(),

                        MarkdownEditor::make('notes')
                            ->label(trans('orders.notes_'))
                            ->columnSpan('full'),

                    ])
                    ->columnSpan(['lg' => fn(?Order $record) => $record === null ? 3 : 2]),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label(trans('general.createdAt'))
                            ->content(fn(Order $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label(trans('general.last_modified_at'))
                            ->content(fn(Order $record): ?string => $record->updated_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('user_id')
                            ->label(trans('orders.order_creator'))
                            ->content(fn(Order $record): ?string => $record->user?->name),

                    ])
                    ->columnSpan(['lg' => 1])
                    ->hidden(fn(?Order $record) => $record === null),
            ])
            ->columns(3);
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

                Tables\Columns\TextColumn::make('client_phone')
                    ->label(trans('orders.client_phone'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('client_address')
                    ->label(trans('orders.client_address'))
                ,

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
                        return Carbon::parse($state)->format('Y-m-d');
                    })
                    ->sortable(),
            ])
            ->filters([
                Filter::make('visit_date')
                    ->form([
                        Forms\Components\Section::make(trans('orders.visit_date'))
                            ->schema([
                                Forms\Components\DatePicker::make('created_from')
                                    ->native(false)
                                    ->label(trans('general.day')),
                            ])

                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn($query, $date) => $query->whereDate('visit_date', '=', $date));
                    }),

                Filter::make('created_at')
                    ->form([
                        Forms\Components\Section::make(trans('general.createdAt'))
                            ->schema([
                                Forms\Components\DatePicker::make('created_from')
                                    ->label(trans('general.from'))
                                    ->native(false),
                                Forms\Components\DatePicker::make('created_until')
                                    ->label(trans('general.to'))
                                    ->native(false),
                            ])

                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['created_from'], fn($query, $date) => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn($query, $date) => $query->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make('export')
                    ->label(trans('general.export'))
            ])
            ->defaultSort('created_at', 'desc')
            ->persistSortInSession();
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'invoice' => Pages\OrderInvoicePage::route('/{record}/invoice'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\ViewOrder::class,
            Pages\EditOrder::class,
            Pages\OrderInvoicePage::class,
        ]);
    }

    static function getOrderStatusOptions(): array
    {
        $options = [];
        foreach (OrderStatus::cases() as $status) {
            $options[$status->value] = $status->label();
        }
        return $options;
    }
}
