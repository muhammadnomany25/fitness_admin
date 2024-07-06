<?php

namespace App\Filament\Resources\DailyReportResource\Pages;

use App\Filament\Resources\DailyReportResource;
use Filament\Resources\Pages\ListRecords;

class ListDailyReports extends ListRecords
{
    protected static string $resource = DailyReportResource::class;
    protected $listeners = ['refreshRelations' => '$refresh'];

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

}
