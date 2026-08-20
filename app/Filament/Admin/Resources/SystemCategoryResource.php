<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SystemCategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SystemCategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Platform Verileri';
    protected static ?string $navigationLabel = 'Sistem Kategorileri';
    protected static ?string $modelLabel = 'Sistem Kategorisi';
    protected static ?string $pluralModelLabel = 'Sistem Kategorileri';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes()
            ->whereNull('user_id');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Kategori Adı')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('icon')
                    ->label('İkon (emoji veya sınıf)')
                    ->maxLength(50),
                Forms\Components\Select::make('type')
                    ->label('Tür')
                    ->options([
                        'expense' => 'Gider',
                        'income' => 'Gelir',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Kategori Adı')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('icon')
                    ->label('İkon'),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tür')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'expense' => 'danger',
                        'income' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'expense' => 'Gider',
                        'income' => 'Gelir',
                        default => $state,
                    }),
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
            'index' => Pages\ListSystemCategories::route('/'),
            'create' => Pages\CreateSystemCategory::route('/create'),
            'edit' => Pages\EditSystemCategory::route('/{record}/edit'),
        ];
    }
}
