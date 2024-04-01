<?php

namespace App\Providers\Filament;

use App\Http\ApiV1\AdminApi\Filament\Pages\Auth\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('cp')
            ->path('cp')
            ->login(Login::class)
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->brandName('IQuest')
            ->brandLogo(asset('cp/images/logo.svg'))
            ->brandLogoHeight('42px')
            ->favicon(asset('cp/images/favicon.svg'))
            ->darkMode(false)
            ->discoverResources(in: app_path('Http/ApiV1/AdminApi/Filament/Resources'), for: 'App\\Http\\ApiV1\\AdminApi\\Filament\\Resources')
            ->discoverPages(in: app_path('Http/ApiV1/AdminApi/Filament/Pages'), for: 'App\\Http\\ApiV1\\AdminApi\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Http/ApiV1/AdminApi/Filament/Widgets'), for: 'App\\Http\\ApiV1\\AdminApi\\Filament\\Widgets')
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
