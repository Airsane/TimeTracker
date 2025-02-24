<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;
use App\MoonShine\Components\ImportComponent;
class ExportImportPage extends Page
{
    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle()
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'ExportImportPage';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
	{
		return [ImportComponent::make()];
	}
}
