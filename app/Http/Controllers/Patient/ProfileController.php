<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use DB;
use Session;

use App\Models\Accounts;
use App\Models\PersonalInformation;

class ProfileController extends Controller
{
    public function index(){

        return view('Main.Patient.Settings.Profile');
    }

    public function update_personal_information(Request $request){

        $rules = [
            'profile_picture' => 'required',

            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',

            'sr_code' => 'required',
            'personal_email' => 'required',
            'gsuite_email' => 'required',

            'grade_level' => 'required',
            'department' => 'required',
            'program' => 'required',

            'birthdate' => 'required',
            'sex' => 'required',
            'civil_status' => 'required',

            'religion' => 'required',
            'contact_number' => 'required',
            'position' => 'required',

            'province' => 'required',
            'city' => 'required',
            'barangay' => 'required',
        ];

        $messages = [
            
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Invalid inputs',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ];
        }

        echo json_encode($response);
    }
}
