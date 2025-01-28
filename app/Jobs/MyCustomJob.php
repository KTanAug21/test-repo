<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Log;

class MyCustomJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('my job testhere');
        try{
            //sleep(300);  // Wait for 300 seconds (5 minutes)
            \Illuminate\Support\Facades\Concurrency::defer(function() {
            
                Log::info('Hello world!');
            });
        }catch(\Exception $e){
            Log::info(json_encode($e));
            Log::info($e->getMessage());
        }
        
        Log::info('completed job');

    }
}
