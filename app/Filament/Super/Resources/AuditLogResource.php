<?php

namespace App\Filament\Super\Resources;

use App\Filament\Super\Resources\AuditLogResource\Pages;
use App\Models\AuditLog;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuditLogResource extends Resource
{
    protected static ?string $model = AuditLog::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Audit & Güvenlik Logları';
    protected static ?string $modelLabel = 'Log';
    protected static ?string $pluralModelLabel = 'Audit Logları';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Kullanıcı'),
                Tables\Columns\TextColumn::make('action')->label('İşlem')->badge(),
                Tables\Columns\TextColumn::make('ip_address')->label('IP Adresi'),
                Tables\Columns\TextColumn::make('user_agent')->label('Tarayıcı')->limit(30),
                Tables\Columns\TextColumn::make('created_at')->label('Zaman')->dateTime('d.m.Y H:i:s'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditLogs::route('/'),
        ];
    }
}
