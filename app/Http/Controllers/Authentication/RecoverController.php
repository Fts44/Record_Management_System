<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Authentication\FunctionController as AuthFunction;

use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use DB;

use App\Rules\PasswordRule as PasswordRule;

use App\Models\Accounts;
use App\Models\PersonalInformation;

class RecoverController extends Controller
{
    public function index(){
        return view('Authentication.Recover');
    }

    public function create(Request $request){
        
        $rules = [
            'email' => ['required', 'email'],
        ];

        if(str_contains($request->email, "@g.batstate-u.edu.ph")){
            array_push($rules['email'], 'exists:personal_information,pi_gsuite_email');
        }
        else{
            array_push($rules['email'], 'exists:personal_information,pi_personal_email');
        }
        
        $messages = [
            'email.exists' => 'The email is not registered.'
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Recovery link not sent.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            
            $acc = Accounts::from('accounts as acc')
                ->join('personal_information as pi', 'acc.acc_id', 'pi.acc_id')
                ->where('pi.pi_personal_email', $request->email)
                ->orWhere('pi.pi_gsuite_email', $request->email)
                ->first();

            $acc->acc_token_expr = Carbon::now()->addMinutes(15);
            $acc->acc_token = Hash::make($request->email);
            $acc->acc_token_last_send = Carbon::now();
            $acc->save();
            
            $this->AuthFunction = new AuthFunction();
            $this->AuthFunction->send_email_token($request->email, 'recover');

            $response = [
                'title' => 'Success!',
                'message' => 'Recovery link is sent to your email!',
                'icon' => 'success',
                'status' => 200
            ];
        }

        $response = json_encode($response, true);
        echo $response;
    }

    public function change_password_index(Request $request){

        $acc_id = Crypt::decrypt($request->acc_id);
        $acc_token = Crypt::decrypt($request->acc_token);

        $acc = Accounts::where('acc_id', $acc_id)->where('acc_token', $acc_token)->first();

        if($acc && $acc->acc_token_expr > Carbon::now()){
            return view('Authentication.ChangePassword');
        }
        else{
            $response = [
                'title' => 'Failed',
                'message' => 'Your link is expired!, Please get new one.',
                'icon' => 'error'
            ];

            return redirect()->route('Authentication.Login.Index')->with([
                'response' => json_encode($response)
            ]);
        }
    }

    public function update(Request $request){

        $rules = [
            'new_password' => ['required', new PasswordRule],
            'confirm_password' => ['required', 'same:new_password'],
        ];

        $messages = [
            'confirm_password.same' => 'The password does not match.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Recovery link not sent.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            $acc_id = Crypt::decrypt($request->acc_id);
            $acc_token = Crypt::decrypt($request->acc_token);
            $password = $request->new_password;
            
            $acc = Accounts::where('acc_id', $acc_id)->where('acc_token', $acc_token)->first();
            $acc->acc_password = $password;
            $acc->acc_token = Hash::make($request->email);
            $acc->save();
      
            $response = [
                'title' => 'Success!',
                'message' => 'Your password is updated!',
                'icon' => 'success',
                'status' => 302,
                'redirect_to' => route('Authentication.Login.Index')
            ];
        }  
        echo json_encode($response);
    }
}
