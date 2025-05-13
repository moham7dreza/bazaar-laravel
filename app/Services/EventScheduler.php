<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Carbon;

final class EventScheduler
{
    public function findNextSession(Carbon $from): Carbon
    {
        // Move to next business day if currently weekend
        if ($from->isWeekend())
        {
            $from = $from->nextWeekday();
        }

        // Jump to next available session time
        return $from->next('13:00');
    }

    public function planTeamMeetings(Carbon $start): array
    {
        return [
            'current_sprint'   => $start->next('Thursday')->setTime(9, 0),
            'next_sprint'      => $start->next('Thursday')->addWeek()->setTime(9, 0),
            'contingency_slot' => $start->next('Friday')->setTime(16, 0),
        ];
    }

    public function getHolidaySchedule(Carbon $date): array
    {
        return [
            'upcoming_holiday' => [
                'start' => $date->nextWeekendDay()->setTime(10, 0),
                'end'   => $date->nextWeekendDay()->setTime(18, 0),
            ],
            'extended_holiday' => [
                'start' => $date->addWeek()->nextWeekendDay()->setTime(10, 0),
                'end'   => $date->addWeek()->nextWeekendDay()->addDay()->setTime(18, 0),
            ],
        ];
    }
}
