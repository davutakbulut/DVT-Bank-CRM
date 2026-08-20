<?php

namespace App\Filament\Super\Resources;

use App\Filament\Super\Resources\SubscriptionResource\Pages;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Abonelikler';
    protected static ?string $navigationGroup = 'Finansal Sistem';
    protected static ?string $modelLabel = 'Abonelik';
    protected static ?string $pluralModelLabel = 'Abonelikler';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->label('Durum')
                    ->options([
                        'active' => 'Aktif',
                        'cancelled' => 'İptal Edildi',
                        'expired' => 'Süresi Doldu',
                        'trial' => 'Deneme Süresi',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Kullanıcı')
                    ->searchable(),
                Tables\Columns\TextColumn::make('plan.name')
                    ->label('Plan')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'cancelled' => 'danger',
                        'expired' => 'warning',
                        'trial' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Başlangıç')
                    ->dateTime('d.m.Y H:i'),
                Tables\Columns\TextColumn::make('ends_at')
                    ->label('Bitiş')
                    ->dateTime('d.m.Y H:i'),
                Tables\Columns\TextColumn::make('payment_provider')
                    ->label('Ödeme Sağlayıcı')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('cancel')
                    ->label('İptal Et')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(fn (Subscription $record) => $record->update(['status' => 'cancelled']))
                    ->requiresConfirmation()
                    ->visible(fn (Subscription $record) => $record->status !== 'cancelled'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
