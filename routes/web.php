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


use App\Http\Controllers\Patient\ProfileController;

use App\Http\Controllers\Admin\Accounts\PatientController;
use App\Http\Controllers\Admin\Accounts\EmployeeController;
use App\Http\Controllers\Admin\Accounts\UnverifiedController;
use App\Http\Controllers\Admin\Accounts\BlockedController;

Route::prefix('/main')->middleware([])->group(function(){
    Route::name('Patient.')->prefix('/patient')->group(function(){
        Route::name('Profile.')->prefix('/profile')->group(function(){
            Route::get('/', [ProfileController::class, 'index'])->name('Index');
        });
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
            Route::name('Patient.')->prefix('/patient')->group(function(){
                Route::get('/', [PatientController::class, 'index'])->name('Index');
                Route::get('/list', [PatientController::class, 'get_patient_list'])->name('Data.Index');
            });

            Route::name('Unverified.')->prefix('/unverified')->group(function(){
                Route::get('/', [UnverifiedController::class, 'index'])->name('Index');
                Route::get('/list', [UnverifiedController::class, 'get_unverified_list'])->name('Data.Index');
                Route::put('update/{acc_id}', [UnverifiedController::class, 'update'])->name('Data.Update');
                Route::delete('delete/{acc_id}', [UnverifiedController::class, 'delete'])->name('Data.Delete');
            });

            Route::name('Employee.')->prefix('/employee')->group(function(){
                Route::get('/', [EmployeeController::class, 'index'])->name('Index');
                Route::get('/list', [EmployeeController::class, 'get_employee_list'])->name('Data.Index');
                Route::get('/view/{acc_id}', [EmployeeController::class, 'view'])->name('Data.View');
                Route::put('/block/{acc_id}', [EmployeeController::class, 'block'])->name('Data.Block');
            });

            Route::name('Blocked.')->prefix('/blocked')->group(function(){
                Route::get('/', [BlockedController::class, 'index'])->name('Index');
                Route::get('/list', [BlockedController::class, 'get_blocked_list'])->name('Data.Index');
                Route::put('/unblock/{acc_id}', [BlockedController::class, 'unblock'])->name('Data.Unblock');
            });
        });

        Route::get('/', function(){
            return redirect()->route('Main.Admin.Accounts.Unverified.Index');
        })->name('Index');
    });
});