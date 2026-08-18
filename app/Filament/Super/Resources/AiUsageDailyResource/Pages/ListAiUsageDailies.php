<?php

namespace App\Filament\Super\Resources\AiUsageDailyResource\Pages;

use App\Filament\Super\Resources\AiUsageDailyResource;
use Filament\Resources\Pages\ListRecords;

class ListAiUsageDailies extends ListRecords
{
    protected static string $resource = AiUsageDailyResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
