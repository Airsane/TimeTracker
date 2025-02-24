<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\ConfiguratorContract;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\TaskResource;
use App\MoonShine\Pages\Calendar;
use App\MoonShine\Pages\ExportImportPage;
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
        $core
            ->resources([
                TaskResource::class,
            ])
            ->pages([
                ...$config->getPages(),
                Calendar::class,
                ExportImportPage::class,
            ])
        ;
    }
}
