<?php

use App\Http\Controllers\ProfileController;
use App\Models\Company;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/companies', function () {
        if (! auth()->user()->is_super_admin) {
            abort(403);
        }

        $companies = Company::all();

        return view('companies.index', compact('companies'));
    });

    Route::get('/projects', function () {
        $projects = Project::all(); // automatically tenant scoped for non-super-admin users

        return view('projects.index', compact('projects'));
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
