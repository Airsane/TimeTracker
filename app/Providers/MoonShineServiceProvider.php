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
use App\MoonShine\Resources\SettingResource;
use App\Models\Setting;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  MoonShine  $core
     * @param  MoonShineConfigurator  $config
     *
     */
    public function boot(CoreContract $core, ConfiguratorContract $config): void
    {
        $this->generateDefaultSettings();
        // $config->authEnable();
        $core
            ->resources([
                TaskResource::class,
                SettingResource::class,
            ])
            ->pages([
                ...$config->getPages(),
                Calendar::class,
                ExportImportPage::class,
            ])
        ;
    }

    private function generateDefaultSettings(){
        if(Setting::count() === 0){
            Setting::setSetting('needed_time_in_one_day', 7.5);
        }
    }

}
