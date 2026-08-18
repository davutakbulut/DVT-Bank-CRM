<?php

namespace App\Filament\Super\Resources;

use App\Filament\Super\Resources\AiAdviceResource\Pages;
use App\Models\AiAdvice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class AiAdviceResource extends Resource
{
    protected static ?string $model = AiAdvice::class;
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = 'AI & Analiz Yönetimi';
    protected static ?string $navigationLabel = 'AI Analiz & Tavsiye Logları';
    protected static ?string $modelLabel = 'AI Analizi';
    protected static ?string $pluralModelLabel = 'AI Analiz & Tavsiyeler';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Kullanıcı')
                    ->disabled(),
                Forms\Components\TextInput::make('type')
                    ->label('Analiz Türü')
                    ->disabled(),
                Forms\Components\TextInput::make('provider')
                    ->label('Sağlayıcı')
                    ->disabled(),
                Forms\Components\TextInput::make('model')
                    ->label('Model')
                    ->disabled(),
                Forms\Components\TextInput::make('prompt_tokens')
                    ->label('Girdi Token (Prompt)')
                    ->numeric()
                    ->disabled(),
                Forms\Components\TextInput::make('completion_tokens')
                    ->label('Çıktı Token (Completion)')
                    ->numeric()
                    ->disabled(),
                Forms\Components\TextInput::make('status')
                    ->label('Durum')
                    ->disabled(),
                Forms\Components\Textarea::make('content')
                    ->label('AI Üretilen Analiz')
                    ->rows(12)
                    ->columnSpanFull()
                    ->disabled(),
                Forms\Components\KeyValue::make('context_snapshot')
                    ->label('Finansal Veri Özeti (Context Snapshot)')
                    ->columnSpanFull()
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Kullanıcı')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('E-posta')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tür')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'analysis' => 'success',
                        'daily' => 'info',
                        'chat' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('provider')
                    ->label('Sağlayıcı')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'groq' => 'primary',
                        'gemini' => 'success',
                        'openrouter' => 'warning',
                        'fallback' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('model')
                    ->label('Model')
                    ->limit(20)
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('prompt_tokens')
                    ->label('Prompt Token')
                    ->numeric()
                    ->sortable()
                    ->placeholder('0'),
                Tables\Columns\TextColumn::make('completion_tokens')
                    ->label('Yanıt Token')
                    ->numeric()
                    ->sortable()
                    ->placeholder('0'),
                Tables\Columns\TextColumn::make('total_tokens')
                    ->label('Toplam Token')
                    ->state(fn (AiAdvice $record): int => ($record->prompt_tokens ?? 0) + ($record->completion_tokens ?? 0))
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'fallback' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('provider')
                    ->label('Sağlayıcı')
                    ->options([
                        'groq' => 'Groq (Llama 3.3)',
                        'gemini' => 'Google Gemini Flash',
                        'openrouter' => 'OpenRouter',
                        'fallback' => 'Çevrimdışı Kural Motoru (Fallback)',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tür')
                    ->options([
                        'analysis' => 'Detaylı Durum Analizi',
                        'daily' => 'Günlük Sabah Brifingi',
                        'chat' => 'Canlı Soru-Cevap',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'success' => 'Başarılı (API)',
                        'fallback' => 'Kural Motoru (Fallback)',
                        'failed' => 'Hatalı',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('İncele'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAiAdvices::route('/'),
        ];
    }
}
