<?php

namespace App\Filament\Super\Resources;

use App\Filament\Super\Resources\SupportTicketResource\Pages;
use App\Models\SupportTicket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SupportTicketResource extends Resource
{
    protected static ?string $model = SupportTicket::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Tüm Destek Talepleri';
    protected static ?string $navigationGroup = 'Destek';
    protected static ?string $modelLabel = 'Destek Talebi';
    protected static ?string $pluralModelLabel = 'Destek Talepleri';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('subject')
                    ->label('Konu')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->label('Durum')
                    ->options([
                        'open' => 'Açık',
                        'in_progress' => 'İşlemde',
                        'resolved' => 'Çözüldü',
                        'closed' => 'Kapalı',
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
                Forms\Components\Select::make('assigned_to')
                    ->label('Atanan Yetkili')
                    ->relationship('assignedAgent', 'name'),
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
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'open' => 'danger',
                        'in_progress' => 'warning',
                        'resolved' => 'success',
                        'closed' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('priority')
                    ->label('Öncelik')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'critical' => 'danger',
                        'high' => 'warning',
                        'medium' => 'info',
                        'low' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('assignedAgent.name')
                    ->label('Atanan'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupportTickets::route('/'),
            'edit' => Pages\EditSupportTicket::route('/{record}/edit'),
        ];
    }
}
