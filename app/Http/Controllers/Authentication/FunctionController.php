<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MailerController as Mailer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use DateTime;

use App\Models\Accounts;

class FunctionController extends Controller
{
    public function check_credentials($email, $password){
        
    }

    public function send_email_token($email, $type){

        $acc_details = Accounts::from('accounts as acc')
            ->join('personal_information as pi', 'acc.acc_id', 'pi.acc_id')
            ->where('pi.pi_personal_email', $email)
            ->orWhere('pi.pi_gsuite_email', $email)
            ->first();

        $name = ($acc_details->pi_firstname) ? $acc_details->pi_firstname : $email;

        $msg_register = "To register this email to your account, please click the button below.";
        $msg_recover = "To recover your account, please click the button below.";
    
        if($type == "register"){
            $title = 'Confirm your email!';
            $message = $msg_register;
        
            $acc_id = Crypt::encrypt($acc_details->acc_id);
            $acc_token = Crypt::encrypt($acc_details->acc_token);
            $btn_action_link = route('Authentication.Register.Verify', ['acc_id' => $acc_id, 'acc_token' => $acc_token]);
        }
        else{
            $title = 'Change your password!';
            $message = $msg_recover;
            $acc_id = Crypt::encrypt($acc_details->acc_id);
            $acc_token = Crypt::encrypt($acc_details->acc_token);
            $btn_action_link = route('Authentication.Recover.Update', ['acc_id' => $acc_id, 'acc_token' => $acc_token]);
        }


        if($acc_details->acc_token_expr > date('Y-m-d H:i:s')){
            $date1 = new DateTime($acc_details->acc_token_expr);
            $date2 = new DateTime(NOW());
            $message = $message."<br>This email is valid for ".($date1->diff($date2))->format("%i mins").".";
        }

        $contact = "0906-716-5785";
        $address = "R. Martinez St., Brgy. Bucana Nasugbu, 4231 Batangas";

        $msg_template = view('Templates.Email'); 
        
        $msg_details = array(
            "{title}" => $title,
            "{name}" => $name,
            "{message}" => $message,
            "{button_action_link}" => $btn_action_link,
            "{msg_type}" => $type,
            "{contact}" => $contact,
            "{address}" => $address,
        );
        
        foreach(array_keys($msg_details) as $key){
            if(strlen($key)>2 && trim($key)!=""){
                $msg_template = str_replace($key, $msg_details[$key], $msg_template);
            }
        }

        $mail = new Request([
            "emailTo" => $email,
            "body" => $msg_template,
            "subject" => $title,
            "images" => [
                "image_illustration" => [
                    "filename" => "assets/images/system/undraw_verify.png",
                    "cid" => "image_illustration",
                    "name" => "Verify.png"
                ],
                "logo" => [
                    "filename" => "assets/photos/logo_w_text.png",
                    "cid" => "logo",
                    "name" => "HSP-logo.png"
                ],
            ]
        ]);

        $mailer = new Mailer();

        if($mailer->send($mail)){
            $status = true;
        }else{
            $status = false;
        };

        return $status;
    }   

}
