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

use App\Http\Controllers\Admin\Accounts\DataController as AccountsDataController;
use App\Http\Controllers\Admin\Accounts\UnverifiedController;

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
        Route::name('Accounts.')->prefix('/accounts')->group(function(){
            
            Route::name('Data.')->prefix('/data')->group(function(){
                Route::get('/', [AccountsDataController::class, 'index'])->name('Index');
                Route::put('update/{acc_id}', [AccountsDataController::class, 'update'])->name('Update');
                Route::delete('delete/{acc_id}', [AccountsDataController::class, 'delete'])->name('Delete');
            });

            Route::name('Unverified.')->prefix('/unverified')->group(function(){
                Route::get('/', [UnverifiedController::class, 'index'])->name('Index');
            });
        });

        Route::get('/', function(){
            return redirect()->route('Main.Admin.Accounts.Unverified.Index');
        })->name('Index');
    });
});