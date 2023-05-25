<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){

        return view('Main.Patient.Settings.Profile');
    }

    public function update(Request $request){

        $rules = [
            'first_name' => [],
            'middle_name' => [],
        ];

    }
}
