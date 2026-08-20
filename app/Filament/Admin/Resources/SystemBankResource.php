<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SystemBankResource\Pages;
use App\Models\Bank;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SystemBankResource extends Resource
{
    protected static ?string $model = Bank::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Platform Verileri';
    protected static ?string $navigationLabel = 'Sistem Bankaları';
    protected static ?string $modelLabel = 'Sistem Bankası';
    protected static ?string $pluralModelLabel = 'Sistem Bankaları';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes()
            ->where('is_system', true);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Banka Adı')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('logo')
                    ->label('Logo URL')
                    ->maxLength(255),
                Forms\Components\ColorPicker::make('color')
                    ->label('Marka Rengi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Banka Adı')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ColorColumn::make('color')
                    ->label('Renk'),
                Tables\Columns\TextColumn::make('logo')
                    ->label('Logo')
                    ->limit(30),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Eklenme')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSystemBanks::route('/'),
            'create' => Pages\CreateSystemBank::route('/create'),
            'edit' => Pages\EditSystemBank::route('/{record}/edit'),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['is_system'] = true;
        $data['user_id'] = null;
        return $data;
    }
}
