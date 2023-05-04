<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Authentication\FunctionController as AuthFunction;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;
use Session;

use App\Rules\PasswordRule as PasswordRule;

use App\Models\Accounts;
use App\Models\PersonalInformation;

class LoginController extends Controller
{
    public function index(){
        return view('Authentication.Login');
    }

    public function create(Request $request){

        $rules = [
            'userid' => 'required',
            'password' => ['required', new PasswordRule]
        ];

        $messages = [
            'userid.required' => 'Email/ SR-Code is required.',
            'password.required' => 'Password is required.' 
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
            $acc = Accounts::from('accounts as acc')
                ->join('personal_information as pi', 'acc.acc_id', 'pi.acc_id')
                ->where('pi.pi_personal_email', $request->userid)
                ->orWhere('pi.pi_gsuite_email', $request->userid)
                ->orWhere('pi.pi_srcode', $request->userid)
                ->first();

            if($acc){


                if(Hash::check($request->password, $acc->acc_password)){

                    if($acc->acc_is_verified){

                        $redirect_to = '';

                        switch($acc->pi_position) {
                            case('admin'):
                                $redirect_to = route('Main.Admin.Index');
                                break;
                 
                            case('nurse'):
                                $redirect_to = route('Main.Nurse.Index');
                                break;

                            case('doctor'):
                                $redirect_to = route('Main.Doctor.Index');
                                break;
                 
                            default:
                                $redirect_to = route('Main.Patient.Index');
                        }

                        $response = [
                            'title' => 'Success!',
                            'message' => 'Proceed to login page!',
                            'icon' => 'success',
                            'status' => 302,
                            'redirect_to' => $redirect_to
                        ];
                    }
                    else{
                        $response = [
                            'title' => 'Warning!',
                            'message' => 'Only verified patients can login!',
                            'icon' => 'info',
                            'status' => 400,
                        ];
                    }

                }
                else{
                    $response = [
                        'title' => 'Warning!',
                        'message' => 'Only verified patients can login!',
                        'icon' => 'info',
                        'status' => 400,
                        'errors' => ['password' => 'The password is incorrect.']
                    ];
                }

            }
            else{
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Invalid inputs',
                    'icon' => 'error',
                    'status' => 400,
                    'errors' => ['userid' => 'Email/SR-Code is not connected to any account!']
                ];
            }
        }

        $response = json_encode($response, true);
        echo $response;
    }
}
