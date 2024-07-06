<?php

namespace App\Filament\Resources\ManualPaymentResource\Pages;

use App\Filament\Resources\ManualPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManualPayments extends ListRecords
{
    protected static string $resource = ManualPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
