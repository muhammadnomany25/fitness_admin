<?php

namespace App\Filament\Resources\CoachCallResource\Pages;

use App\Filament\Resources\CoachCallResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoachCall extends EditRecord
{
    protected static string $resource = CoachCallResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
