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

class SuperPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('super')
            ->path('super')
            ->login()
            ->brandName('DVT Bank CRM — Süper Admin')
            ->font('Plus Jakarta Sans')
            ->colors([
                'primary' => Color::Red,
            ])
            ->navigationItems([
                NavigationItem::make('Kullanıcı Paneline Dön')
                    ->url('/app')
                    ->icon('heroicon-o-arrow-left')
                    ->sort(-100),
                NavigationItem::make('Yönetim Paneli (Admin)')
                    ->url('/admin')
                    ->icon('heroicon-o-shield-check')
                    ->group('Paneller Arası Geçiş'),
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Kullanıcı Paneline Dön')
                    ->url('/app')
                    ->icon('heroicon-o-arrow-left'),
                MenuItem::make()
                    ->label('Yönetim Paneli')
                    ->url('/admin')
                    ->icon('heroicon-o-shield-check'),
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
            ->discoverResources(in: app_path('Filament/Super/Resources'), for: 'App\\Filament\\Super\\Resources')
            ->discoverPages(in: app_path('Filament/Super/Pages'), for: 'App\\Filament\\Super\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Super/Widgets'), for: 'App\\Filament\\Super\\Widgets')
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
