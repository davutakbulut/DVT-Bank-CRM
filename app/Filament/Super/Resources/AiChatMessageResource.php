<?php

namespace App\Filament\Super\Resources;

use App\Filament\Super\Resources\AiChatMessageResource\Pages;
use App\Models\AiChatMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AiChatMessageResource extends Resource
{
    protected static ?string $model = AiChatMessage::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'AI & Analiz Yönetimi';
    protected static ?string $navigationLabel = 'AI Canlı Sohbet Logları';
    protected static ?string $modelLabel = 'Sohbet Mesajı';
    protected static ?string $pluralModelLabel = 'AI Sohbet Logları';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Kullanıcı')
                    ->disabled(),
                Forms\Components\TextInput::make('role')
                    ->label('Rol (User / Assistant)')
                    ->disabled(),
                Forms\Components\TextInput::make('tokens')
                    ->label('Tahmini Token')
                    ->numeric()
                    ->disabled(),
                Forms\Components\Textarea::make('content')
                    ->label('Mesaj İçeriği')
                    ->rows(8)
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
                Tables\Columns\TextColumn::make('role')
                    ->label('Gönderen')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'user' => 'info',
                        'assistant' => 'success',
                        'system' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'user' => '👤 Kullanıcı',
                        'assistant' => '🤖 AI Koç',
                        'system' => '⚙️ Sistem',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('content')
                    ->label('Mesaj İçeriği')
                    ->limit(60)
                    ->searchable(),
                Tables\Columns\TextColumn::make('tokens')
                    ->label('Token')
                    ->numeric()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Gönderen')
                    ->options([
                        'user' => 'Kullanıcı Soruları',
                        'assistant' => 'AI Koç Yanıtları',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('İncele'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAiChatMessages::route('/'),
        ];
    }
}
