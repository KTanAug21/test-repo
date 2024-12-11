<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
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

require __DIR__.'/auth.php';
