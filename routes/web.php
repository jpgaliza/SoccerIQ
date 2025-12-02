<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'ok';
});

Route::get('/login', function () {
    return response()->json(['message' => 'Unauthenticated'], 401);
})->name('login');
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/quiz', function () {
    return Inertia::render('Quiz');
})->middleware(['auth', 'verified'])->name('quiz');

Route::get('/historico', function () {
    return Inertia::render('GameHistory');
})->middleware(['auth', 'verified'])->name('history');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
