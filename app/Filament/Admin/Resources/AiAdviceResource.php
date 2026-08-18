<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AiAdviceResource\Pages;
use App\Models\AiAdvice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AiAdviceResource extends Resource
{
    protected static ?string $model = AiAdvice::class;
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = 'AI & Finansal Analizler';
    protected static ?string $navigationLabel = 'AI Koç Analiz Logları';
    protected static ?string $modelLabel = 'AI Analizi';
    protected static ?string $pluralModelLabel = 'AI Analizleri';

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
                Forms\Components\TextInput::make('prompt_tokens')
                    ->label('Prompt Token')
                    ->numeric()
                    ->disabled(),
                Forms\Components\TextInput::make('completion_tokens')
                    ->label('Yanıt Token')
                    ->numeric()
                    ->disabled(),
                Forms\Components\Textarea::make('content')
                    ->label('Üretilen Analiz')
                    ->rows(10)
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
                Tables\Columns\TextColumn::make('type')
                    ->label('Tür')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('provider')
                    ->label('Sağlayıcı')
                    ->badge(),
                Tables\Columns\TextColumn::make('total_tokens')
                    ->label('Harcanan Token')
                    ->state(fn (AiAdvice $record): int => ($record->prompt_tokens ?? 0) + ($record->completion_tokens ?? 0))
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'success' ? 'success' : 'warning'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
