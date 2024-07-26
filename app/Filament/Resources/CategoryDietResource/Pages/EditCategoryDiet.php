<?php

namespace App\Filament\Resources\CategoryDietResource\Pages;

use App\Filament\Resources\CategoryDietResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryDiet extends EditRecord
{
    protected static string $resource = CategoryDietResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
