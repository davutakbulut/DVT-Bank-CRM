<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('DVT Bank CRM — Yönetim Paneli')
            ->font('Plus Jakarta Sans')
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->navigationItems([
                NavigationItem::make('Kullanıcı Paneline Dön')
                    ->url('/app')
                    ->icon('heroicon-o-arrow-left')
                    ->sort(-100),
                NavigationItem::make('Süper Admin Paneli')
                    ->url('/super')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->group('Paneller Arası Geçiş'),
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Kullanıcı Paneline Dön')
                    ->url('/app')
                    ->icon('heroicon-o-arrow-left'),
                MenuItem::make()
                    ->label('Süper Admin Paneli')
                    ->url('/super')
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => view('filament.custom-head'),
            )
            ->renderHook(
                PanelsRenderHook::TOPBAR_START,
                fn () => view('filament.custom-topbar-start'),
            )
            ->renderHook(
                PanelsRenderHook::FOOTER,
                fn () => view('filament.custom-footer'),
            )
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
