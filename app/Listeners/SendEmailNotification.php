<?php

namespace App\Listeners;

use App\Events\TaskExecuted;
use App\Notifications\TaskCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TaskExecuted  $event
     * @return void
     */
    public function handle(TaskExecuted $event)
    {
        $event->task->notify(new TaskCompleted($event->output));
    }
}
