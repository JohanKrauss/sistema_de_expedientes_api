<?php

use App\Http\Controllers\{
    ProfileController,
    UsersController
};
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
*/

Route::get('/', function () {
    return Inertia('Dashboard');
})->name('dashboard');


Route::prefix('/usuarios')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('user.index');
    Route::get('/crear', [UsersController::class, 'create'])->name('user.create');
    Route::post('/agregar', [UsersController::class, 'store'])->name('user.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/users', function () {
    $users = User::all();
    return response()->json(['users' => $users]);
});

require __DIR__.'/auth.php';
