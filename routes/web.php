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
    return redirect(URL::temporarySignedRoute('signed-route', now()->addMinutes(5), ['user' => 1], false));
});

Route::get('signed-route/{user}', function (Request $request) {
    if (! URL::hasValidSignature($request, absolute: false)) {
        abort(401);
    }

    return response('Valid Signature');
})->name('signed-route');

require __DIR__.'/auth.php';
