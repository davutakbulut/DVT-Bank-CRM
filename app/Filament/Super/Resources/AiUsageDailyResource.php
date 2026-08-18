<?php

namespace App\Filament\Super\Resources;

use App\Filament\Super\Resources\AiUsageDailyResource\Pages;
use App\Models\AiUsageDaily;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AiUsageDailyResource extends Resource
{
    protected static ?string $model = AiUsageDaily::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'AI & Analiz Yönetimi';
    protected static ?string $navigationLabel = 'Günlük Token & Maliyet Takibi';
    protected static ?string $modelLabel = 'Günlük AI Kullanımı';
    protected static ?string $pluralModelLabel = 'Günlük Token Kullanımları';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Tarih')
                    ->date('d.m.Y')
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('provider')
                    ->label('AI Sağlayıcısı')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'groq' => 'primary',
                        'gemini' => 'success',
                        'openrouter' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('requests')
                    ->label('Toplam İstek Sayısı')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tokens')
                    ->label('Toplam Tüketilen Token')
                    ->numeric()
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Son Güncelleme')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('provider')
                    ->label('Sağlayıcı')
                    ->options([
                        'groq' => 'Groq (Llama 3.3)',
                        'gemini' => 'Google Gemini Flash',
                        'openrouter' => 'OpenRouter',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAiUsageDailies::route('/'),
        ];
    }
}
