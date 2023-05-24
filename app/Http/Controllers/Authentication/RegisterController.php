<?php

namespace App\Http\Controllers\Authentication;

use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Authentication\FunctionController as AuthFunction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use DB;

use App\Rules\PasswordRule as PasswordRule;

use App\Models\Accounts;
use App\Models\PersonalInformation;

class RegisterController extends Controller
{
    public function index(){   
        return view('Authentication.Register');
    }
    
    public function create(Request $request){
        $rules = [
            'email' => ['required', 'email', 'unique:personal_information,pi_personal_email', 'unique:personal_information,pi_gsuite_email'],
            'password' => ['required', 'max:20', new PasswordRule],
            'confirm_password' => ['required', 'max:20', 'same:password'],
            'classification' => ['required', 'in:patient,infirmary personnel'],
            'position' => ['in:,nurse,doctor,dentist,student,teacher,school personnel']
        ];

        $messages = [];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Account not created.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{

            $acc = new Accounts;
            $acc->acc_email_verified = false;
            $acc->acc_password = Hash::make($request->password);
            $acc->acc_created_date = Carbon::now();
            $acc->acc_token = Hash::make($request->email);
            $acc->acc_token_last_send = Carbon::now();
            $acc->acc_token_expr = Carbon::now()->addMinutes(15);
            $acc->acc_type = 'standard';

            $personal_info = new PersonalInformation;
            $personal_info->pi_classification = $request->classification;
            $personal_info->pi_position = $request->position;
           
            if(str_contains($request->email, "@g.batstate-u.edu.ph")){
                $personal_info->pi_gsuite_email = $request->email;
                $acc->acc_is_verified = ($request->classification=="patient") ? true : false;
            }
            else{
                $personal_info->pi_personal_email = $request->email;
                $acc->acc_is_verified = false;
            }
            
            $acc->save();
            $personal_info->acc_id = $acc->getKey();
            $personal_info->save();

            $this->AuthFunction = new AuthFunction();
            $this->AuthFunction->send_email_token($request->email, 'register');

            $response = [
                'title' => 'Success!',
                'message' => 'Verification link is sent to your email!',
                'icon' => 'success',
                'status' => 200
            ];
        }

        $response = json_encode($response, true);
        echo $response;
    }

    public function update(Request $request){
        $acc_id = Crypt::decrypt($request->acc_id);
        $acc_token = Crypt::decrypt($request->acc_token);

        $acc = Accounts::where('acc_id', $acc_id)->where('acc_token', $acc_token)->first();

        if($acc){
            if($acc->acc_email_verified == true){
                $response = [
                    'title' => 'Opps',
                    'message' => 'Your email is already verified!',
                    'icon' => 'info'
                ];
            }
            else if($acc->acc_token_expr == null or $acc->acc_token_expr > date('Y-m-d')){
                $acc->acc_email_verified = true;
                $acc->save();
                $response = [
                    'title' => 'Success',
                    'message' => 'Your email is successfully verified!',
                    'icon' => 'success'
                ];
            }
            else{
                $response = [
                    'title' => 'Failed',
                    'message' => 'Your email link is expired!, Resend <a href="#">Here.</a>',
                    'icon' => 'error'
                ];
            }
        }
        else{
            $response = [
                'title' => 'Failed',
                'message' => 'Your account has been deleted!, Please register again.',
                'icon' => 'error'
            ];
        };

        return redirect()->route('Authentication.Login.Index')->with([
            'response' => json_encode($response)
        ]);
    }
}
