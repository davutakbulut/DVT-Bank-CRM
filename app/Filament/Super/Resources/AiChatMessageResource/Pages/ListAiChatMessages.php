<?php

namespace App\Filament\Super\Resources\AiChatMessageResource\Pages;

use App\Filament\Super\Resources\AiChatMessageResource;
use Filament\Resources\Pages\ListRecords;

class ListAiChatMessages extends ListRecords
{
    protected static string $resource = AiChatMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
