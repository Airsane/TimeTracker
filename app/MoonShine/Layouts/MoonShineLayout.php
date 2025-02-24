<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Laravel\Components\Layout\{Locales, Notifications, Profile, Search};
use MoonShine\UI\Components\{Breadcrumbs,
    Components,
    Layout\Flash,
    Layout\Div,
    Layout\Body,
    Layout\Burger,
    Layout\Content,
    Layout\Footer,
    Layout\Head,
    Layout\Favicon,
    Layout\Assets,
    Layout\Meta,
    Layout\Header,
    Layout\Html,
    Layout\Layout,
    Layout\Logo,
    Layout\Menu,
    Layout\Sidebar,
    Layout\ThemeSwitcher,
    Layout\TopBar,
    Layout\Wrapper,
    When};
use App\MoonShine\Resources\TaskResource;
use App\MoonShine\Pages\Calendar;
use MoonShine\MenuManager\MenuItem;

use MoonShine\AssetManager\Css;
use MoonShine\AssetManager\Js;
use Vite;
use App\MoonShine\Pages\ExportImportPage;

final class MoonShineLayout extends AppLayout
{
    protected function assets(): array
    {
        return [
            ...parent::assets(),
            Css::make(Vite::asset('resources/css/app.css')),
            Js::make(Vite::asset('resources/js/app.js')),
        ];
    }

    protected function menu(): array
    {
        return [
            MenuItem::make('Tasks', TaskResource::class),
            MenuItem::make('Calendar', Calendar::class),
            MenuItem::make('Export/Import', ExportImportPage::class),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }

    public function build(): Layout
    {
        return parent::build();
    }
}
