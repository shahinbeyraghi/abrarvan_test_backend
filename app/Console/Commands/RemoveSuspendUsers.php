<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class RemoveSuspendUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:remove-suspended';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        User::removeSuspendedUsers();
    }
}
