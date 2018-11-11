<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cron\CronExpression;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class Task extends Model
{
    use Notifiable;

    protected $fillable = [
        'description',
        'command',
        'expression',
        'notification_email',
        'is_active',
        'dont_overlap',
        'run_in_maintenance'
    ];

    public function getNextRunAttribute()
    {
        return CronExpression::factory($this->getCronExpression())->getNextRunDate('now', 0, false, 'America/Chicago')->format('Y-m-d h:i A');
    }

    public function getLastRunAttribute()
    {
        if($last = $this->results()->orderBy('id', 'desc')->first()) {
            return $last->ran_at->setTimezone('America/Chicago')->format('Y-m-d h:i A');
        }
        return 'N/A';
    }

    public function getAverageRuntimeAttribute()
    {
        return number_format(($this->results()->avg('duration') / 1000) ?? 0.00, 2);
    }

    public function getCronExpression()
    {
        if (!$this->expression) {
            $this->expression = "* * * * *";
        }

        return $this->expression;
    }

    public function getActive()
    {
        return Cache::rememberForever('tasks.active', function () {
            return Task::getAll()->filter(function($task) {
                return $task->is_active;
            });
        });
    }

    public function getAll()
    {
        return Cache::rememberForever('tasks.all', function () {
            return Task::all();
        });
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->notification_email;
    }
}
