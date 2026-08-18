<?php

namespace App\Filament\Super\Resources;

use App\Filament\Super\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Sistem & AI Ayarları';
    protected static ?string $modelLabel = 'Ayar';
    protected static ?string $pluralModelLabel = 'Ayarlar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Ayar Anahtarı (key)')
                    ->required(),
                Forms\Components\TextInput::make('group')
                    ->label('Grup (ai, general, payment)')
                    ->required(),
                Forms\Components\Textarea::make('value')
                    ->label('Değer (value)')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('description')
                    ->label('Açıklama')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group')->label('Grup')->badge(),
                Tables\Columns\TextColumn::make('key')->label('Ayar Anahtarı')->searchable(),
                Tables\Columns\TextColumn::make('value')->label('Değer')->limit(50),
                Tables\Columns\TextColumn::make('description')->label('Açıklama')->limit(40),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
