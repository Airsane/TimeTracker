<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;

use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Number;
use App\MoonShine\Fields\Time;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;

/**
 * @extends ModelResource<Task>
 */
class TaskResource extends ModelResource
{
    protected string $model = Task::class;

    protected string $title = 'Tasks';

    protected string $description = 'Manage your tasks';

    protected bool $createInModal = true;

    protected bool $editInModal = true;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Description'),
            Time::make('Time Taken'),
            Date::make('Date')->format('d. m. Y')->default(now()->format('d. m. Y')),
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Text::make('Description'),
                Time::make('Time Taken'),
                Date::make('Date')->format('d. m. Y'),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
        ];
    }

    /**
     * @param Task $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'description' => 'required',
            'time_taken' => ['required', 'regex:/^([0-9]|[0-1][0-9]|2[0-3]):[0-5][0-9]$/'],
            'date' => 'required',
        ];
    }

    protected function metrics(): array{
        return [
            ValueMetric::make('Total Time Worked This Month')->value(Task::totalTimeWorkedThisMonth()),
        ];
    }


}
