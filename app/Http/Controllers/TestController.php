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
            $token=env('TOKEN');

            $forge = new Forge($token);
            $server = $forge->createServer([
                "provider"=> ServerProviders::HETZNER,
                "credential_id"=> 1,
            "credential_id" => 89351,
                "name" => "test-server-sj",
                "type" => ServerTypes::APP,
                "size" => "40",
                "database" => "test_sj",
                "database_type" => InstallableServices::MYSQL_8,
                "php_version" => InstallableServices::PHP_83,
                "region" => "1",
            ]);

            dd( $server);
        }catch(\Exception $e){
            Log::info( $e->getMessage() );
            report( $e );
            dd( $e );
        }

    }
}
