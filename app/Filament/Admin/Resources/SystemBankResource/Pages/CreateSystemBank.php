<?php

namespace App\Filament\Admin\Resources\SystemBankResource\Pages;

use App\Filament\Admin\Resources\SystemBankResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSystemBank extends CreateRecord
{
    protected static string $resource = SystemBankResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['is_system'] = true;
        $data['user_id'] = null;
        return $data;
    }
}
