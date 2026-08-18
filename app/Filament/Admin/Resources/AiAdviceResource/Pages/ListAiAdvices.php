<?php

namespace App\Filament\Admin\Resources\AiAdviceResource\Pages;

use App\Filament\Admin\Resources\AiAdviceResource;
use Filament\Resources\Pages\ListRecords;

class ListAiAdvices extends ListRecords
{
    protected static string $resource = AiAdviceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
