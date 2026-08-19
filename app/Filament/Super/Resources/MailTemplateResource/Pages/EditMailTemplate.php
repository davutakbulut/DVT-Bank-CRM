<?php

namespace App\Filament\Super\Resources\MailTemplateResource\Pages;

use App\Filament\Super\Resources\MailTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMailTemplate extends EditRecord
{
    protected static string $resource = MailTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
