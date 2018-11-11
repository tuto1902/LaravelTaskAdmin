<?php

namespace App\Providers;

use App\Events\TaskExecuted;
use App\Observers\TaskObserver;
use App\Task;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Task::observe(TaskObserver::class);
        $this->app->resolving(Schedule::class, function ($schedule) {
            $this->schedule($schedule);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function schedule(Schedule $schedule)
    {
        $tasks = app('App\Task')->getActive();
        foreach ($tasks as $task) {
            $event = $schedule->exec($task->command);
            $event->cron($task->expression)
                ->before(function () use ($event) {
                    $event->start = microtime(true);
                })
                ->after(function () use ($event, $task) {
                    $elapsed_time = microtime(true) - $event->start;
                    event(new TaskExecuted($task, $elapsed_time));
                })
                ->sendOutputTo(storage_path('task-'.sha1($task->expression . $task->command)));
        }
    }
}
