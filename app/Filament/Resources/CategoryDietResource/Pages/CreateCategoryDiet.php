<?php

namespace App\Filament\Resources\CategoryDietResource\Pages;

use App\Filament\Resources\CategoryDietResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryDiet extends CreateRecord
{
    protected static string $resource = CategoryDietResource::class;

    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
