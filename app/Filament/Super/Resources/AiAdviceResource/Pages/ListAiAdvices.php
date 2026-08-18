<?php

namespace App\Filament\Super\Resources\AiAdviceResource\Pages;

use App\Filament\Super\Resources\AiAdviceResource;
use Filament\Resources\Pages\ListRecords;

class ListAiAdvices extends ListRecords
{
    protected static string $resource = AiAdviceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
