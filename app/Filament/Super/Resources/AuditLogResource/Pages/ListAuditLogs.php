<?php

namespace App\Filament\Super\Resources\AuditLogResource\Pages;

use App\Filament\Super\Resources\AuditLogResource;
use Filament\Resources\Pages\ListRecords;

class ListAuditLogs extends ListRecords
{
    protected static string $resource = AuditLogResource::class;
}
