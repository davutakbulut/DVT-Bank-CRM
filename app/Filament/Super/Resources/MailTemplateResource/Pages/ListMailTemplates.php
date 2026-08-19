<?php

namespace App\Filament\Super\Resources\MailTemplateResource\Pages;

use App\Filament\Super\Resources\MailTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMailTemplates extends ListRecords
{
    protected static string $resource = MailTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
