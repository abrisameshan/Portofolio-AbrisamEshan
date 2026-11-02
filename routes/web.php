<?php

use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::post('/contact', [PortfolioController::class, 'storeContact'])->name('contact.store');

// Admin Passcode Barrier
Route::get('/inbox/login', [PortfolioController::class, 'showLogin'])->name('inbox.login');
Route::post('/inbox/login', [PortfolioController::class, 'login'])->name('inbox.login.submit');
Route::post('/inbox/logout', [PortfolioController::class, 'logout'])->name('inbox.logout');

// Protected Inbox & Message Management
Route::middleware('admin')->group(function () {
    Route::get('/inbox', [PortfolioController::class, 'inbox'])->name('inbox');
    Route::patch('/inbox/{id}/toggle-read', [PortfolioController::class, 'toggleMessageRead'])->name('inbox.toggleRead');
    Route::delete('/inbox/{id}', [PortfolioController::class, 'destroyMessage'])->name('inbox.destroy');
});
