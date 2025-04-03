<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Log;

class testCommandLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       
        $showProcess = new Process([

          
            "composer",
    
            "--version"
    
        ]);
    
        $showProcess->setTimeout(180);
    
        $showProcess->mustRun();
    
        $output = $showProcess->getOutput();
        Log::info('from within command');
        Log::info($output);
        dd($output );

    }
}
