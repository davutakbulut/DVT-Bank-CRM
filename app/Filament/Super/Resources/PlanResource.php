<?php

namespace App\Filament\Super\Resources;

use App\Filament\Super\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Abonelik Planları';
    protected static ?string $modelLabel = 'Plan';
    protected static ?string $pluralModelLabel = 'Planlar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Plan Adı')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->label('Fiyat (TL)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('interval')
                    ->label('Aralık (month/year)')
                    ->default('month')
                    ->required(),
                Forms\Components\TextInput::make('max_debts')
                    ->label('Maksimum Borç Limiti')
                    ->numeric(),
                Forms\Components\TextInput::make('max_banks')
                    ->label('Maksimum Banka Limiti')
                    ->numeric(),
                Forms\Components\Toggle::make('ai_advisor')
                    ->label('AI Finansal Koç Aktif'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Satışta / Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Plan Adı'),
                Tables\Columns\TextColumn::make('price')->label('Fiyat (TL)')->money('TRY'),
                Tables\Columns\IconColumn::make('ai_advisor')->label('AI Koç')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
