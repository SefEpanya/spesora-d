<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiagnosticController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Routes Web SPESORA Diagnostic Flash
|--------------------------------------------------------------------------
|
| Définition des routes publiques, diagnostiques et administratives de l'application.
|
*/

// Accueil & Catalogue des Prestations SPESORA GROUP
Route::get('/', [DiagnosticController::class, 'index'])->name('home');
Route::get('/services', [DiagnosticController::class, 'services'])->name('services');

// Parcours Diagnostic Flash & Restitution
Route::prefix('diagnostic')->name('diagnostic.')->group(function () {
    Route::get('/', [DiagnosticController::class, 'create'])->name('create');
    Route::post('/', [DiagnosticController::class, 'store'])->name('store');
    
    Route::get('/{diagnostic}', [ReportController::class, 'show'])->name('report');
    Route::get('/{diagnostic}/print', [ReportController::class, 'print'])->name('print');
    
    // Actions post-diagnostic : Renvoi d'email et demande d'accompagnement consultant
    Route::post('/{diagnostic}/send-email', [DiagnosticController::class, 'sendEmail'])->name('send-email');
    Route::post('/{diagnostic}/request-consulting', [DiagnosticController::class, 'requestConsulting'])->name('request-consulting');
});

// Administration & Suivi des Diagnostics (Consultants SPESORA GROUP)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('/diagnostic/{diagnostic}', [DashboardController::class, 'destroy'])->name('diagnostic.destroy');
    Route::get('/mail-preview/{type}/{uuid?}', [DashboardController::class, 'previewMail'])->name('mail-preview');
});
