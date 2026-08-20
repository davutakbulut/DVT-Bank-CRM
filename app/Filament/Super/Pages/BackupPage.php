<?php

namespace App\Filament\Super\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class BackupPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-server-stack';
    protected static ?string $navigationLabel = 'Yedekleme';
    protected static ?string $navigationGroup = 'Sistem Yönetimi';
    protected static ?string $title = 'Veritabanı Yedekleme';
    protected static string $view = 'filament.super.pages.backup-page';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backup')
                ->label('Yedek Al')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Yedek Almak İstediğinize Emin Misiniz?')
                ->modalDescription('Bu işlem veritabanının tam yedeğini alacaktır.')
                ->action(function () {
                    // In production this would trigger mysqldump
                    Notification::make()
                        ->title('Yedekleme başlatıldı')
                        ->body('Veritabanı yedekleme işlemi arka planda başlatıldı.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
