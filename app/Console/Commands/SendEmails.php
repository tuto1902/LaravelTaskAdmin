<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send'; // php artisan email:send

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send some emails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Sending emails...');
        sleep(random_int(5,7));
        $this->line('Done!');
    }
}
