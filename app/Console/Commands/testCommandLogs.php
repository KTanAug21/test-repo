<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


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
        Log::info('checking other command');
       
        $scriptPath = '/var/www/html/app/Console/Commands/debug_composer.sh';
        #$scriptPath = '/home/admin_kath/development/php/test-repo/app/Console/Commands/debug_composer.sh';
        
        $process = new Process([

          $scriptPath
    
        ]);
        $process->run();

        // Check if the process was successful
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Get the output from the script (which will be in JSON format)
        $output = $process->getOutput();
      
        $errorOutput = $process->getErrorOutput();
        // Optionally decode the JSON if you want to manipulate it in PHP
       
        Log::info( $output );
        Log::info( $errorOutput ) ;
       
    }
}
