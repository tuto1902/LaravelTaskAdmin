<?php

namespace App\Events;

use App\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskExecuted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;
    public $output;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Task $task, $elapsed_time)
    {
        $this->task = $task;
        // Get execution results
        if (file_exists(storage_path('task-'.sha1($task->expression . $task->command)))) {
            $this->output = file_get_contents(storage_path('task-'.sha1($task->expression . $task->command)));
            $task->results()->create([
                'duration' => $elapsed_time * 1000,
                'result' => $this->output
            ]);
            unlink(storage_path('task-'.sha1($task->expression . $task->command)));
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
