<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Accounts;
use App\Models\PersonalInformation;

class BlockedController extends Controller
{
    public function block($acc_id){
        $status = false;

        $acc = Accounts::where('acc_id', $acc_id)->first();
        $acc->acc_is_blocked = 1;
        
        if($acc->save()){
            $status = true;
        } 

        return $status;
    }

    public function unblock($acc_id){
        $acc = Accounts::where('acc_id', $acc_id)->first();
        $acc->acc_is_blocked = 0;
        $acc->save();

        $response = [
            'title' => 'Success',
            'message' => 'Acc no.'.sprintf("%05d", $acc_id).' - Successfully unblocked!',
            'icon' => 'success',
            'status' => 200,
        ];
        
        $response = json_encode($response, true);
        echo $response;
    }

    public function get_blocked_list(){
        $accounts = Accounts::from('accounts as acc')
        ->join('personal_information as pi', 'acc.acc_id', 'pi.acc_id')
        ->where('acc.acc_is_verified', 1)
        ->where('acc.acc_is_blocked', 1)
        ->get();

        $records = array();
        foreach($accounts as $acc){
            $rows = array();
            $rows['acc_id'] = sprintf("%05d",$acc->acc_id);
            $rows['acc_profile_pic'] = '<img class="rounded-circle table-img" src="'.(($acc->pi_photo) ? asset('storage/photos/'.$acc->pi_photo) : asset('assets/photos/default-profile.jpg')).'">';
            
            if($acc->pi_firstname){
                $rows['acc_name'] = ucwords($acc->pi_firstname.' '.($acc->pi_middlename ?: '').' '.$acc->pi_lastname);
            }
            else{
                $rows['acc_name'] = ucwords("Not set");
            }

            if($acc->pi_gsuite_email && $acc->pi_personal_email){
                $rows['acc_email'] = 
                '<li>'.$acc->pi_gsuite_email.'</li>
                <li>'.$acc->pi_personal_email.'</li>';
            }
            else{
                $rows['acc_email'] =
                '<li>'.($acc->pi_gsuite_email ?: $acc->pi_personal_email).'</li>';
            }

            $rows['acc_classification'] = ucwords($acc->pi_classification);
            $rows['acc_position'] = ucwords($acc->pi_position);
            $rows['acc_created_date'] = date_format(date_create($acc->acc_created_date), 'M d, Y');
            $update = '<button type="button" class="btn btn-primary btn-sm" id="view_btn_'.$acc->acc_id.'" onclick="view(`#view_btn_'.$acc->acc_id.'`,`'.$acc->acc_id.'`)"><label>View</label></button>';
            $delete = '<button type="button" class="btn btn-danger btn-sm" id="unblock_btn'.$acc->acc_id.'" onclick="unblock(`#unblock_btn'.$acc->acc_id.'`,`'.$acc->acc_id.'`)"><label>Unblock</label></button>';
            $rows['action'] = $update." ".$delete;
            $records[] = $rows;
        }

        $output = array(
            "data" => $records
        );

        echo json_encode($output);
    }

    public function index(){

        return view('Main.Admin.Accounts.Blocked');
    }
}
