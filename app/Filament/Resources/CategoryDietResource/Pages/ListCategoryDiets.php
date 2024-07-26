<?php

namespace App\Filament\Resources\CategoryDietResource\Pages;

use App\Filament\Resources\CategoryDietResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryDiets extends ListRecords
{
    protected static string $resource = CategoryDietResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
