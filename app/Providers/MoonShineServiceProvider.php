<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRoleResource;
use App\MoonShine\Resources\TaskResource;
use App\MoonShine\Pages\Calendar;
use MoonShine\AssetManager\AssetManager;
use MoonShine\AssetManager\Css;
use MoonShine\AssetManager\Js;
use Vite;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        // $config->authEnable();

        Css::make(Vite::asset('resources/css/app.css'));
        Js::make(Vite::asset('resources/js/app.js'));
        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                TaskResource::class,
            ])
            ->pages([
                ...$config->getPages(),
                Calendar::class,
            ])
        ;
    }
}
