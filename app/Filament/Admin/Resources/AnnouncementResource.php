<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'İçerik Yönetimi';
    protected static ?string $modelLabel = 'Duyuru';
    protected static ?string $pluralModelLabel = 'Duyurular';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Başlık')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('body')
                    ->label('İçerik')
                    ->columnSpanFull(),
                Forms\Components\Select::make('audience')
                    ->label('Hedef Kitle')
                    ->options([
                        'all' => 'Tüm Kullanıcılar',
                        'free' => 'Ücretsiz Plan',
                        'pro' => 'Pro Plan',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->label('Başlangıç Tarihi'),
                Forms\Components\DateTimePicker::make('ends_at')
                    ->label('Bitiş Tarihi'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif mi?')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable(),
                Tables\Columns\TextColumn::make('audience')
                    ->label('Hedef Kitle')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'all' => 'Tüm Kullanıcılar',
                        'free' => 'Ücretsiz Plan',
                        'pro' => 'Pro Plan',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'all' => 'gray',
                        'free' => 'success',
                        'pro' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif mi?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Başlangıç Tarihi')
                    ->dateTime('d.m.Y H:i'),
                Tables\Columns\TextColumn::make('ends_at')
                    ->label('Bitiş Tarihi')
                    ->dateTime('d.m.Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
