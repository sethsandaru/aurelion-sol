<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PullHotelsCommand extends Command
{
    protected $signature = 'hotels:pull';
    protected $description = 'Pull hotels from ALL SERVICES, transform and merge them then store to DB';

    public function handle(): void
    {

    }
}
