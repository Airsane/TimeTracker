<?php

declare(strict_types=1);

namespace App\MoonShine\Components;

use Closure;
use App\Models\Task;
use MoonShine\UI\Components\MoonShineComponent;

/**
 * @method static static make()
 */
final class Calendar extends MoonShineComponent
{
    protected string $view = 'admin.components.calendar';

    public function __construct()
    {
        parent::__construct();

        //
    }

    /*
     * @return array<string, mixed>
     */
    protected function viewData(): array
    {

        $tasks = Task::where('date', '>=', now()->startOfMonth())->where('date', '<=', now()->endOfMonth())->get();
        $tasksByDate = [];
        foreach ($tasks as $task) {
            $tasksByDate[$task->date->format('Y-m-d')][] = $task;
        }

        return ["tasksByDate" => $tasksByDate, "neededTimeInMonth" => Task::neededTimeInMonth(), "neededTimeInOneDay" => Task::neededTimeInOneDay(), "totalTimeWorkedMonth" => Task::totalTimeWorkedMonth(now()->month, now()->year)];
    }
}
