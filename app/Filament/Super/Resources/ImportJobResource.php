<?php

namespace App\Filament\Super\Resources;

use App\Filament\Super\Resources\ImportJobResource\Pages;
use App\Models\ImportJob;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ImportJobResource extends Resource
{
    protected static ?string $model = ImportJob::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static ?string $navigationLabel = 'İçe Aktarma İşleri';
    protected static ?string $navigationGroup = 'Sistem Yönetimi';
    protected static ?string $modelLabel = 'İçe Aktarma İşi';
    protected static ?string $pluralModelLabel = 'İçe Aktarma İşleri';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Kullanıcı')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tür')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'failed' => 'danger',
                        'processing' => 'warning',
                        'pending' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('total_rows')
                    ->label('Toplam Satır'),
                Tables\Columns\TextColumn::make('imported_rows')
                    ->label('İşlenen Satır'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'pending' => 'Bekliyor',
                        'processing' => 'İşleniyor',
                        'completed' => 'Tamamlandı',
                        'failed' => 'Başarısız',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->form([
                        \Filament\Forms\Components\Textarea::make('error_log')
                            ->label('Hata Logu')
                            ->rows(10)
                            ->disabled(),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImportJobs::route('/'),
        ];
    }
}
