<?php

namespace Sellvation\CCMV2\Scheduler\Facades;

use Arr;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Schema;
use Sellvation\CCMV2\Scheduler\Enums\ScheduleIntervals;
use Sellvation\CCMV2\Scheduler\Enums\ScheduleTaskType;
use Sellvation\CCMV2\Scheduler\Models\ScheduledTask;

class CcmScheduler
{
    public function registerCommands()
    {
        if (Schema::hasTable('scheduled_tasks')) {
            $tasks = ScheduledTask::where('is_active', 1)->get();

            foreach ($tasks as $task) {
                $params = $this->getOptions($task);

                if ($task->type === ScheduleTaskType::EXTENSION) {
                    $event = Schedule::command($task->command, $params)
                        ->storeOutput()
                        ->runInBackground();

                    $intervalType = Arr::get($task->pattern, 'type');
                    switch ($intervalType) {
                        case ScheduleIntervals::everySecond->name:
                        case ScheduleIntervals::everyTwoSeconds->name:
                        case ScheduleIntervals::everyThreeSeconds->name:
                        case ScheduleIntervals::everyFourSeconds->name:
                        case ScheduleIntervals::everyFiveSeconds->name:
                        case ScheduleIntervals::everyTenSeconds->name:
                        case ScheduleIntervals::everyFifteenSeconds->name:
                        case ScheduleIntervals::everyThirtySeconds->name:
                        case ScheduleIntervals::everyMinute->name:
                        case ScheduleIntervals::everyTwoMinutes->name:
                        case ScheduleIntervals::everyThreeMinutes->name:
                        case ScheduleIntervals::everyFourMinutes->name:
                        case ScheduleIntervals::everyFiveMinutes->name:
                        case ScheduleIntervals::everyTenMinutes->name:
                        case ScheduleIntervals::everyFifteenMinutes->name:
                        case ScheduleIntervals::everyThirtyMinutes->name:
                        case ScheduleIntervals::hourly->name:
                        case ScheduleIntervals::everyTwoHours->name:
                        case ScheduleIntervals::everyThreeHours->name:
                        case ScheduleIntervals::everyFourHours->name:
                        case ScheduleIntervals::everySixHours->name:
                        case ScheduleIntervals::everyOddHours->name:
                            $event->$intervalType();
                            break;
                        case ScheduleIntervals::dailyAt->name:
                            $event->dailyAt(Arr::get($task->pattern, 'time'));
                            break;
                        case ScheduleIntervals::weeklyOn->name:
                            $event->weeklyOn(Arr::get($task->pattern, 'days'), Arr::get($task->pattern, 'time'));
                            break;
                        case ScheduleIntervals::monthlyOn->name:
                            $event->monthlyOn(Arr::get($task->pattern, 'day'), Arr::get($task->pattern, 'time'));
                            break;
                        case ScheduleIntervals::yearlyOn->name:
                            $event->yearlyOn(Arr::get($task->pattern, 'month'), Arr::get($task->pattern, 'day'), Arr::get($task->pattern, 'time'));
                            break;
                    }

                    if ($task->without_overlapping) {
                        $event->withoutOverlapping(3600 * 8); // 8 hours
                    }
                    if ($task->on_one_server) {
                        $event->onOneServer();
                    }
                    if ($task->email_success) {
                        $event->emailOutputTo($task->email_success);
                    }
                    if ($task->email_failure) {
                        $event->emailOutputTo($task->email_failure);
                    }

                    $event->onSuccessWithOutput(
                        function () use ($task, $event) {
                            $this->saveLog($task, $event);
                        }
                    )->onFailure(
                        function () use ($task, $event) {
                            $this->saveLog($task, $event, false);
                        }
                    )->after(function () {});
                }
            }
        }
    }

    public function run(ScheduledTask $task)
    {
        /** @var Command $command */
        $command = new $task->command;

        if (Artisan::call($command->getName(), $this->getOptions($task, true)) === 0) {
            $isSuccess = true;
        } else {
            $isSuccess = false;
        }

        $task->scheduledTaskLogs()->create([
            'is_success' => $isSuccess,
            'output' => Artisan::output(),
            'error_message' => null,
        ]);
    }

    private function getOptions(ScheduledTask $task, $assoc = false): array
    {
        $options = [];

        if ($assoc) {
            $options['--no-interaction'] = true;
        } else {
            $options[] = '--no-interaction';
        }
        foreach ($task->options as $option => $value) {
            if (! \Str::endsWith($option, '_value')) {
                if ($values = \Arr::get($task->options, $option.'_value')) {
                    foreach (explode(' ', $values) as $optionValue) {
                        if (! empty($optionValue)) {
                            if ($assoc) {
                                $options['--'.$option] = $optionValue;
                            } else {
                                $options[] = '--'.$option.'='.$optionValue;
                            }
                        }
                    }
                } else {
                    if ($assoc) {
                        $options['--'.$option] = 1;
                    } else {
                        $options[] = '--'.$option;
                    }
                }
            }
        }

        return $options;
    }

    private function getArguments(ScheduledTask $task): array
    {
        $arguments = [];

        foreach ($task->arguments as $argument => $value) {
            if (! empty($value)) {
                $arguments[$argument] = $value;
            }
        }

        return $arguments;
    }

    private function saveLog(ScheduledTask $task, \Illuminate\Console\Scheduling\Event $event, $isSuccess = true)
    {
        if (file_exists($event->output)) {
            $task->scheduledTaskLogs()->create([
                'is_success' => $isSuccess,
                'output' => file_get_contents($event->output),
                'error_message' => null,
            ]);

            unlink($event->output);
        } else {
            $task->scheduledTaskLogs()->create([
                'is_success' => $isSuccess,
                'output' => 'NO OUTPUT',
                'error_message' => null,
            ]);
        }
    }
}
