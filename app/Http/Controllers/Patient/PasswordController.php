<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Session;

use App\Rules\PasswordRule as PasswordRule;

use App\Models\Accounts;


class PasswordController extends Controller
{
    public function index(){

        return view('Main.Patient.Settings.Password');
    }

    public function update(Request $request){

        $rules = [
            'old_password' => ['required'],
            'new_password' => ['required', new PasswordRule],
            'retype_new_password' => ['required', 'same:new_password']
        ];

        $messages = [
            'retype_new_password.same' => 'The password does not match.',
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
        else{
            $acc_id = Crypt::decrypt(Session::get('hsp_user_data')['acc_id']);
            $acc = Accounts::where('acc_id', $acc_id)->first();

            if(Hash::check($request->old_password, $acc->acc_password)){
                $acc->acc_password = Hash::make($request->new_password);
                $acc->save();

                $response = [
                    'title' => 'Success!',
                    'message' => 'Password updated',
                    'icon' => 'success',
                    'status' => 200,
                ];
            }
            else{
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Invalid inputs',
                    'icon' => 'error',
                    'status' => 400,
                    'errors' => ['old_password' => 'Incorrect password.']
                ];
            }
        }

        echo json_encode($response);
    }
}
