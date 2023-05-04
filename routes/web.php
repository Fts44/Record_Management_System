<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\Authentication\RecoverController;

Route::name('Authentication.')->prefix('/')->middleware([])->group(function(){
    Route::name('Login.')->group(function(){
        Route::get('/', [LoginController::class, 'index'])->name('Index');
        Route::post('/create', [LoginController::class, 'create'])->name('Create');
    });

    Route::name('Register.')->prefix('/register')->group(function(){
        Route::get('/', [RegisterController::class, 'index'])->name('Index');
        Route::post('/create', [RegisterController::class, 'create'])->name('Create');
        Route::get('/verify/{acc_id}/{acc_token}', [RegisterController::class, 'update'])->name('Verify');
    });

    Route::name('Recover.')->prefix('/recover')->group(function(){
        Route::get('/', [RecoverController::class, 'index'])->name('Index');
        Route::post('/create', [RecoverController::class, 'create'])->name('Create');
        Route::get('/change-password/{acc_id}/{acc_token}', [RecoverController::class, 'change_password_index'])->name('Update');
        Route::post('/change-password/{acc_id}/{acc_token}', [RecoverController::class, 'update'])->name('Update');  
    });
});

Route::name('Main.')->prefix('/main')->middleware([])->group(function(){
    Route::name('Patient.')->prefix('/patient')->group(function(){
        Route::get('/', function(){
            echo 'patient';
        })->name('Index');
    });

    Route::name('Nurse.')->prefix('/nurse')->group(function(){
        Route::get('/', function(){
            echo 'nurse';
        })->name('Index');
    });

    Route::name('Doctors.')->prefix('/doctors')->group(function(){
        Route::get('/', function(){
            echo 'doctors';
        })->name('Index');
    });

    Route::name('Admin.')->prefix('/admin')->group(function(){
        Route::get('/', function(){
            echo 'admin';
        })->name('Index');
    });
});