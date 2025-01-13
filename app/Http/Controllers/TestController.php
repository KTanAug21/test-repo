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
}
