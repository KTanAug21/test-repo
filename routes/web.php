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


use Illuminate\Support\Facades\Storage;

Route::get('/upload-text', function () {
      // The string to be written into the text file
      $content = "This is the content of the text file.";

      // Define the file name (you can dynamically generate it as needed)
      $fileName = 'example.txt';
  
      // Upload the file to the S3 disk (or the default disk configured in your filesystems.php)
      Storage::disk('s3')->put($fileName, $content);
});


Route::get('/get-text', function () {

    // The file name you want to retrieve
    $fileName = 'example.txt';

    // Retrieve the file content from S3 (or local storage if that's your disk)
    $content = Storage::disk('s3')->get($fileName);

    // Return or use the file content
    return response($content, 200)->header('Content-Type', 'text/plain');
});




Route::get('/dispatch-job', function () {
    \Log::info('dispatching job');
    // Dispatch the job to the queue
    MyCustomJob::dispatch();

    return 'Job has been dispatched!';
});

Route::get('env-var',function(){
    dd( env('MY_VARIABLE') );
});

Route::get('env-var-a',function(){
    dd( env('MY_VARIABLE_A') ); //
});

Route::get('/get-image',function(){

    // check path
    if( Storage::exists('laravel.png')){
        $path=Storage::temporaryUrl('laravel.png', now()->addMinutes(15));
        dd($path);
        return "<html>
    <body>
    Hello
    <img src='https://fls-9e4ba251-9a4c-49bb-9699-a42b347b8660.367be3a2035528943240074d0096e0cd.r2.cloudflarestorage.com/laravel.png?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=5784425a0271330ded3475b45f53575e%2F20250228%2Fauto%2Fs3%2Faws4_request&X-Amz-Date=20250228T100811Z&X-Amz-SignedHeaders=host&X-Amz-Expires=900&X-Amz-Signature=633a86c10f52283b940c13a39a2c6c8d469e0b8d1e44c2bbf902258a651e91ec' />
    </body>
    </html>";
    }else{
        dd('no');
    }
    
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
