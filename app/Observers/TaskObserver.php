<?php

namespace App\Observers;

use App\Task;
use Illuminate\Support\Facades\Cache;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        Cache::forget('tasks.all');
        Cache::forget('tasks.active');
    }

    /**
     * Handle the task "updated" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        Cache::forget('tasks.all');
        Cache::forget('tasks.active');
    }

    /**
     * Handle the task "deleted" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        Cache::forget('tasks.all');
        Cache::forget('tasks.active');
    }
}
