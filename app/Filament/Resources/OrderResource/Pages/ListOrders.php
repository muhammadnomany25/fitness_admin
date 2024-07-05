<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make(trans('status.all')),
            trans('status.new') => Tab::make()->query(fn($query) => $query->where('status', 'new')),
            trans('status.inProgress') => Tab::make()->query(fn($query) => $query->where('status', 'inProgress')),
            trans('status.Completed') => Tab::make()->query(fn($query) => $query->where('status', 'Completed')),
            trans('status.Duplicated') => Tab::make()->query(fn($query) => $query->where('status', 'Duplicated')),
            trans('status.Reassigned') => Tab::make()->query(fn($query) => $query->where('status', 'Reassigned')),
        ];
    }
}
