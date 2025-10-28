<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyJobController;
use App\Http\Controllers\ApplicationController;

Route::get('/', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/company/jobs', [CompanyJobController::class, 'index'])->name('company.jobs.index');
    Route::get('/company/jobs/create', [CompanyJobController::class, 'create'])->name('company.jobs.create');
    Route::post('/company/jobs', [CompanyJobController::class, 'store'])->name('company.jobs.store');

    Route::post('/jobs/{job}/apply', [ApplicationController::class, 'store'])->name('jobs.apply');
});

Route::get('/dashboard', function () {
    return redirect()->route('jobs.index');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';