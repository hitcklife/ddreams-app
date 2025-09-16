<?php

namespace App\Console\Commands;

use App\Jobs\ProcessAutoBids;
use Illuminate\Console\Command;

class ProcessAutoBidsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto-bids:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually process auto-bids for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Processing auto-bids...');
        
        $job = new ProcessAutoBids();
        $job->handle();
        
        $this->info('Auto-bid processing completed!');
    }
}
