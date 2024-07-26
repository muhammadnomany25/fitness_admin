<?php

namespace App\Filament\Resources\BodyPartResource\Pages;

use App\Filament\Resources\BodyPartResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBodyPart extends CreateRecord
{
    protected static string $resource = BodyPartResource::class;

    protected function getRedirectUrl(): string {
        return $this->getResource()::getUrl('index');
    }
}
