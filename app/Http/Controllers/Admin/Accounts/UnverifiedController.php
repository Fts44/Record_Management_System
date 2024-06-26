<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Accounts;
use App\Models\PersonalInformation;

class UnverifiedController extends Controller
{

    public function get_unverified_list(){

        $accounts = Accounts::from('accounts as acc')
            ->join('personal_information as pi', 'acc.acc_id', 'pi.acc_id')
            ->where('acc.acc_is_verified', 0)
            // ->orWhere('acc.acc_email_verified', 0)
            ->where('acc.acc_is_blocked', 0)
            ->select('acc.acc_id', 'pi.pi_personal_email', 'pi.pi_classification', 'pi.pi_position', 'acc.acc_created_date')
            ->get();

        $records = array();
        foreach($accounts as $acc){
            $rows = array();
            $rows['acc_id'] = sprintf("%05d",$acc->acc_id);
            $rows['acc_email'] = '<li>'.$acc->pi_personal_email.'</li>';
            $rows['acc_email_verification'] = ($acc->acc_email_verified) ? '<span class="badge bg-success">Verified</span>' : '<span class="badge bg-danger">Not Verified</span>';
            $rows['acc_classification'] = ucwords($acc->pi_classification);
            $rows['acc_position'] = ucwords($acc->pi_position);
            $rows['acc_created_date'] = date_format(date_create($acc->acc_created_date), 'M d, Y');

            $update = '';
            $delete = '<button type="button" class="btn btn-danger btn-sm" id="delete_btn_'.$acc->acc_id.'" onclick="remove(`#delete_btn_'.$acc->acc_id.'`,`'.$acc->acc_id.'`)"><label>Delete</label></button>';
            
            if(!$acc->acc_is_verified){
                $update = '<button type="button" class="btn btn-primary btn-sm" id="update_btn_'.$acc->acc_id.'" onclick="accept(`#update_btn_'.$acc->acc_id.'`,`'.$acc->acc_id.'`)"><label>Accept</label></button>';
            }

            $rows['action'] = $update." ".$delete;
            $records[] = $rows;
        }

        $output = array(
            "data" => $records
        );

        echo json_encode($output);
    }

    public function update(Request $request){

        $acc = Accounts::where('acc_id', $request->acc_id)->first();
        $acc->acc_is_verified = 1;
        $acc->save();

        $response = [
            'title' => 'Success',
            'message' => 'Acc no.'.sprintf("%05d", $acc->acc_id).' - Successfully verified!',
            'icon' => 'success',
            'status' => 200,
        ];
        
        $response = json_encode($response, true);
        echo $response;
    }

    public function delete(Request $request){

        $acc = Accounts::where('acc_id', $request->acc_id)->first()->delete();
        $pi = PersonalInformation::where('acc_id', $request->acc_id)->first()->delete();

        $response = [
            'title' => 'Success',
            'message' => 'Acc no.'.sprintf("%05d", $request->acc_id).' - Successfully deleted!',
            'icon' => 'success',
            'status' => 200,
        ];

        $response = json_encode($response, true);
        echo $response;
    }

    public function index(){
        return view('Main.Admin.Accounts.Unverified');
    }

}
