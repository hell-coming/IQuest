<?php

namespace App\Providers;

use App\Apis\VKApi;
use App\Http\ApiV1\AdminApi\Support\Enums\NavigationGroup;
use Filament\Facades\Filament;
use Filament\Forms\Components\Contracts\CanBeLengthConstrained;
use Filament\Forms\Components\Field;
use Filament\Navigation\NavigationGroup as FilamentNavigationGroup;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use VK\Client\VKApiClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme(config('app.force_https'));

        app()->bind(VKApi::class, function () {
            return new VKApi(
                new VKApiClient(),
                config('vk.vk_access_token'),
                config('vk.vk_group_id'),
            );
        });

        Filament::serving(function () {
            Filament::registerNavigationGroups([
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::BOOKING->value)
                    ->icon('heroicon-o-lock-closed'),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::SCHEDULE->value)
                    ->icon('heroicon-m-calendar-days'),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::QUEST_COMPONENTS->value)
                    ->icon('heroicon-o-inbox'),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::LOCATIONS->value)
                    ->icon('heroicon-o-building-office-2'),
                FilamentNavigationGroup::make()
                    ->label(NavigationGroup::CONTACTS->value)
                    ->icon('heroicon-o-phone'),
            ]);
        });

        Field::macro('maxLengthWithHint', function (int $maxLength) {
            return $this
                ->when($this instanceof CanBeLengthConstrained, fn(CanBeLengthConstrained $field) => $field->maxLength($maxLength))
                ->hint(fn($state) => Str::length($state) . '/' . $maxLength)
                ->afterStateUpdated(fn(Field $component, $state) => $component->hint(Str::length($state) . '/' . $maxLength . ' символов'))
                ->live();
        });
    }
}
