<?php

namespace App\Filament\Resources;

use App\Constants\AppConstants;
use App\Filament\Resources\CompletedOrdersResource\Pages;
use App\Filament\Resources\CompletedOrdersResource\RelationManagers;
use App\Models\CompletedOrders;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

class CompletedOrdersResource extends Resource
{
    protected static ?int $navigationSort = AppConstants::CompletedOrdersSideMenuOrder;

    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return trans('general.orders_group');
    }

    public static function getNavigationLabel(): string
    {
        return trans('orders.completed_orders');
    }

    public static function getModelLabel(): string
    {
        return trans('orders.completed_orders');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('orders.completed_orders');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
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
                    ->label(trans('orders.notes_'))
                    ->extraAttributes([
                        'style' => 'max-width: 300px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; white-space: normal;',
                    ]),

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
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
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
            'index' => Pages\ListCompletedOrders::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return Order::query()
            ->where('status', 'Completed');
    }
}
