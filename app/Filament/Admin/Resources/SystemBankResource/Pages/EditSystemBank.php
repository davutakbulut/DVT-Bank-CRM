<?php

namespace App\Filament\Admin\Resources\SystemBankResource\Pages;

use App\Filament\Admin\Resources\SystemBankResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSystemBank extends EditRecord
{
    protected static string $resource = SystemBankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
