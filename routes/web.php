<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

// Auth routes are defined in routes/auth.php (Breeze)

Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Application pages

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/quiz', [\App\Http\Controllers\QuizController::class, 'index'])->name('quiz');
    Route::post('/quiz/start', [\App\Http\Controllers\QuizController::class, 'start'])->name('quiz.start');
    Route::post('/quiz/answer', [\App\Http\Controllers\QuizController::class, 'answer'])->name('quiz.answer');
    Route::post('/quiz/finish', [\App\Http\Controllers\QuizController::class, 'finish'])->name('quiz.finish');

    Route::get('/history', function () {
        return Inertia::render('GameHistory');
    })->name('history');
});
