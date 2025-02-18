<?php

namespace App\Http\Controllers;

use Laravel\Forge\Forge;
use Illuminate\Http\Request;
use Laravel\Forge\Resources\ServerTypes;
use Laravel\Forge\Resources\ServerProviders;
use Laravel\Forge\Resources\InstallableServices;
use Log;

class TestController extends Controller
{
    function createServer(){
        
        try{
            $token=env('TOKEN_');

            $forge = new Forge($token);
            dd( $forge->server(872508) );
            $server = $forge->createServer([
                "provider" => ServerProviders::DIGITAL_OCEAN,
                "name" => 'test-mili',
                "type" => ServerTypes::MEILISEARCH,
                "php_version" => InstallableServices::PHP_83,
                'database_type' => InstallableServices::MYSQL,
                "region" => "lon1",
                "size" => "04",
                "credential_id" => 144596,
                "circle"=>21425
            ]);

            dd( $server);
        }catch(\Exception $e){
            Log::info( $e->getMessage() );
            report( $e );
            dd( $e );
        }

    }
    function createWorker(){
        
        try{
            $token=env('TOKEN_');
            $payload = [
                'connection' => 'database',
                'timeout' => 0,
                'sleep' => 60,
                'tries' => null,
                'processes' => 1,
                'stopwaitsecs' => 10,
                'daemon' => true,
                'force' => false,
                'php_version' => 'php83',
                'queue' => 'default',
                'directory'=>'/home/forge/test-kath.bot.nu/sample'
                ]; 

            $forge = new Forge($token);
            $worker = $forge->createWorker(882412,2604314,$payload,true);
            dd( $worker );
        }catch(\Exception $e){
            Log::info( $e->getMessage() );
            report( $e );
            dd( $e );
        }

    }
}
