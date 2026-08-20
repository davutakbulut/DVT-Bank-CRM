<?php

namespace App\Filament\Admin\Resources\SystemCategoryResource\Pages;

use App\Filament\Admin\Resources\SystemCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSystemCategory extends CreateRecord
{
    protected static string $resource = SystemCategoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = null;
        return $data;
    }
}
