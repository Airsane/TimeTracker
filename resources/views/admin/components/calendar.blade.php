@php
    // Default to current date if not provided
    $year = $year ?? now()->year;
    $month = $month ?? now()->month;
    $selectedDate = $date ?? now()->day;

    $date = \Carbon\Carbon::createFromDate($year, $month, 1);
    $daysInMonth = $date->daysInMonth;
    $firstDayOfWeek = ($date->copy()->firstOfMonth()->dayOfWeek - 1) % 7; // Adjust to start from Monday (0)
    $lastDayOfPrevMonth = $date->copy()->subMonth()->endOfMonth()->day;
    $monthName = $date->format('F Y');

    $neededTimeInOneDay = 7.5;

    // Calculate weekdays in month for total needed hours
    $weekdaysInMonth = 0;
    $tempDate = $date->copy()->startOfMonth();
    while ($tempDate->month === $date->month) {
        if ($tempDate->isWeekday()) {
            $weekdaysInMonth++;
        }
        $tempDate->addDay();
    }
    $totalNeededHours = $weekdaysInMonth * $neededTimeInOneDay;

    // Get prev/next month links
    $prevMonth = $date->copy()->subMonth();
    $nextMonth = $date->copy()->addMonth();
    
    $totalWorkedMinutes = 0;
    foreach ($tasksByDate as $date => $tasks) {
        foreach ($tasks as $task) {
            list($hours, $minutes) = explode(':', $task['time_taken']);
            $totalWorkedMinutes += ($hours * 60) + $minutes;
        }
    }
    $totalWorkedHours = $totalWorkedMinutes / 60;
@endphp

<div class="bg-white rounded-lg shadow p-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $monthName }}</h2>
            <div class="text-sm text-gray-600 mt-1">
                Worked: {{ number_format($totalWorkedHours, 1) }}h / Needed: {{ number_format($totalNeededHours, 1) }}h
            </div>
        </div>
        <div class="flex space-x-4">
            <button onclick="" class="p-2 rounded-full hover:bg-gray-100 transition-colors duration-200">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button onclick="" class="p-2 rounded-full hover:bg-gray-100 transition-colors duration-200">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-7 gap-1 mb-4">
        <div class="text-center font-semibold text-gray-600 pb-3">Mon</div>
        <div class="text-center font-semibold text-gray-600 pb-3">Tue</div>
        <div class="text-center font-semibold text-gray-600 pb-3">Wed</div>
        <div class="text-center font-semibold text-gray-600 pb-3">Thu</div>
        <div class="text-center font-semibold text-gray-600 pb-3">Fri</div>
        <div class="text-center font-semibold text-gray-600 pb-3">Sat</div>
        <div class="text-center font-semibold text-gray-600 pb-3">Sun</div>
    </div>

    <div class="grid grid-cols-7 gap-1">
        @php
            $day = $lastDayOfPrevMonth - $firstDayOfWeek + 1;
            $baseClasses = "text-center min-h-[120px] p-2 rounded-lg transition-all duration-200 hover:shadow-md hover:scale-[1.02]";

            // Previous month days
            for($i = 0; $i < $firstDayOfWeek; $i++) {
                echo "<div class='{$baseClasses} text-gray-400 hover:bg-gray-50'><div class='font-semibold mb-1'>{$day}</div><div class='text-xs'>00:00</div><div class='text-xs'>(0,00)</div></div>";
                $day++;
            }

            // Current month days
            for($day = 1; $day <= $daysInMonth; $day++) {
                $isToday = $day == now()->day && $month == now()->month && $year == now()->year;
                $bgColor = $isToday ? 'bg-gray-100 hover:bg-gray-200' : 'hover:bg-gray-50';
                $taskHtml = "<div class='text-xs'>00:00</div><div class='text-xs'>(0,00)</div>";
                $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
                if (isset($tasksByDate[$date])) {
                    $tasks = $tasksByDate[$date];
                    $totalTime = 0;

                    foreach ($tasks as $task) {
                        list($hours, $minutes) = explode(':', $task['time_taken']);
                        $totalTime += ($hours * 60) + $minutes;
                    }

                    $totalHours = floor($totalTime / 60);
                    $totalMinutes = $totalTime % 60;
                    $decimalHours = $totalHours + ($totalMinutes / 60);

                    if (!$isToday) {
                        $bgColor = $totalTime/60 >= $neededTimeInOneDay ? 'bg-green-100 hover:bg-green-200' : 'bg-yellow-100 hover:bg-yellow-200';
                    }

                    $formattedTime = sprintf('%02d:%02d', $totalHours, $totalMinutes);
                    $taskHtml = "<div class='text-xs'>{$formattedTime}</div><div class='text-xs'>(" . number_format($decimalHours, 2, ',', '') . ")</div>";
                }

                $classes = "{$baseClasses} text-gray-800 {$bgColor}";

                echo "<div class='{$classes}'>
                    <div class='font-semibold mb-1'>{$day}</div>
                    {$taskHtml}
                </div>";
            }

            // Next month days
            $day = 1;
            for($i = ($firstDayOfWeek + $daysInMonth) % 7; $i > 0 && $i < 7; $i++) {
                echo "<div class='{$baseClasses} text-gray-400 hover:bg-gray-50'><div class='font-semibold mb-1'>{$day}</div><div class='text-xs'>00:00</div><div class='text-xs'>(0,00)</div></div>";
                $day++;
            }
        @endphp
    </div>
</div>
