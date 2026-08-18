<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SupportTicketResource\Pages;
use App\Models\SupportTicket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SupportTicketResource extends Resource
{
    protected static ?string $model = SupportTicket::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Destek Talepleri';
    protected static ?string $modelLabel = 'Destek Talebi';
    protected static ?string $pluralModelLabel = 'Destek Talepleri';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subject')
                    ->label('Konu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->label('Talep Durumu')
                    ->options([
                        'open' => 'Açık',
                        'in_progress' => 'İnceleniyor',
                        'resolved' => 'Çözüldü',
                        'closed' => 'Kapatıldı',
                    ])
                    ->required(),
                Forms\Components\Select::make('priority')
                    ->label('Öncelik')
                    ->options([
                        'low' => 'Düşük',
                        'medium' => 'Normal',
                        'high' => 'Yüksek',
                        'critical' => 'Kritik',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('message')
                    ->label('İlk Mesaj')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Kullanıcı')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Konu')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Durum')
                    ->colors([
                        'danger' => 'open',
                        'warning' => 'in_progress',
                        'success' => 'resolved',
                        'gray' => 'closed',
                    ]),
                Tables\Columns\BadgeColumn::make('priority')
                    ->label('Öncelik')
                    ->colors([
                        'gray' => 'low',
                        'info' => 'medium',
                        'warning' => 'high',
                        'danger' => 'critical',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Açılış')
                    ->dateTime('d.m.Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupportTickets::route('/'),
            'create' => Pages\CreateSupportTicket::route('/create'),
            'edit' => Pages\EditSupportTicket::route('/{record}/edit'),
        ];
    }
}
