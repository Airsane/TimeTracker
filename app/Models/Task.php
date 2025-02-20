<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 *
 *
 * @property int $id
 * @property string $description
 * @property int $time_taken
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereTimeTaken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Task extends Model
{
    protected $fillable = [
        'description',
        'time_taken',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    protected function timeTaken(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (!$value) return 0;
                if (!is_numeric($value)) return $value;
                $hours = floor($value / 60);
                $minutes = $value % 60;
                return sprintf('%02d:%02d', $hours, $minutes);
            },
            set: function ($value) {
                if (!$value) return 0;
                [$hours, $minutes] = explode(':', $value);
                return ((int)$hours * 60) + (int)$minutes;
            }
        );
    }

    public static function totalTimeWorkedThisMonth(): string
    {
        $tasks = self::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->get();

        $totalMinutes = 0;
        foreach ($tasks as $task) {
            if (!str_contains($task->time_taken, ':')) {
                $totalMinutes += $task->time_taken;
                continue;
            }
            [$hours, $minutes] = explode(':', $task->time_taken);
            $totalMinutes += $hours * 60 + $minutes;
        }

        $minutes = $totalMinutes % 60;
        $hours = floor($totalMinutes / 60);

        return sprintf('%02d:%02d', $hours, $minutes);
    }
}
