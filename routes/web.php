<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Jobs\MyCustomJob;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test-cors',function(){
    return view('test-cors');
});

Route::get('nope-cors',function(){
    return view('test-okay');
});



Route::get('/check-node-version', function () {
    // Execute the command to get the Node.js version
    $nodeVersion = exec('node -v');
    
    // Return the Node.js version as a response
    dd( $nodeVersion);
});

Route::get('apicheck',function(){
    $forgeApiUrl = "https:://forge.laravel.com/api/v1/servers/882412/sites/2604314/deployment/deploy";
    $forgeApiHeaders = [
      'Authorization' =>  'Bearer ' . env('API_TOKEN'),
      'Accept' =>  'application/json',
      'Content-Type' =>  'application/json',
    ];
    $projectDeploy = Http::withHeaders($forgeApiHeaders)
    ->post($forgeApiUrl);
    dd( $projectDeploy);
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('signed-verify', function () {
    $url = URL::temporarySignedRoute('signed-route', now()->addMinutes(5), ['user' => 1], false);
    \Log::info( $url );
    return redirect($url);
});

Route::get('signed-route/{user}', function (Request $request) {
    \Log::debug('Request URL: ', ['url' => $request->fullUrl()]);
    \Log::debug('Request parameters: ', ['params' => $request->all()]);
    if (! URL::hasValidSignature($request, absolute: false)) {
        abort(401);
    }

    return response('Valid Signature');
})->name('signed-route');


Route::post('/process', function () {
    defer(function () {
        // Task to run after the response
        logger('Deferred task executed.');
    });

    return 'ok';
});

//Route::get('create-server', [\App\Http\Controllers\TestController::class, 'createServer']);

Route::get('signed-absolute', function () { 
    $url = URL::temporarySignedRoute('verify-absolute', now()->addMinutes(5), ['user' => 1]);
    \Log::info( $url );
    return redirect($url);
})->name('signed-absolute');

Route::get('verify-absolute/{user}', function (Request $request) { 
    \Log::debug('Request URL: ', ['url' => $request->fullUrl()]);
    \Log::debug('Request parameters: ', ['params' => $request->all()]);
    if (! URL::hasValidSignature(request: $request)) { 
        abort(401); 
    } 
    return response('Valid Signature From Absolute URL');
})->name('verify-absolute');

Route::get('test-kath-test-okay',function(){
    dd(phpinfo());
});

Route::get('create-mili',[\App\Http\Controllers\TestController::class, 'createServer']);



Route::get('/dispatch-job', function () {
    \Log::info('dispatching job');
    // Dispatch the job to the queue
    MyCustomJob::dispatch();

    return 'Job has been dispatched!';
});


Route::get('/api/test', function () {
    dd('ok');
});
Route::get('/api/first/third', function () {
    dd('ok');
});
Route::get('/api/firstsecond', function () {
    dd('ok');
});

Route::get('test-flush',function(){
    Cache::tags(['test'])->put('test', 'test', 300);
    $cache = Cache::tags(['test'])->get('test');
    Log::info( $cache );

    Cache::tags(['test'])->flush(); 
    $cacheNow = Cache::tags(['test'])->get('test');
    Log::info( $cacheNow );
    
    dd( $cache, $cacheNow ); 
});

require __DIR__.'/auth.php';
