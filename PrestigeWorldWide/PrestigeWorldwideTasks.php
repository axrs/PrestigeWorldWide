<?php

namespace Statamic\Addons\PrestigeWorldwide;

use Statamic\Extend\Tasks;
use Illuminate\Console\Scheduling\Schedule;

class PrestigeWorldwideTasks extends Tasks
{
    /**
     * Define the task schedule
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    public function schedule(Schedule $schedule)
    {
        // $schedule->command('prestigeworldwide:recurring')
        //     ->everyMinute()
        //     ->pingBefore('https://cronhub.io/ping/20ea29f0-0c79-11e9-bad3-65985bc7f86f');
    }
}
