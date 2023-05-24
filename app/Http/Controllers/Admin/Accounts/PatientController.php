<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Accounts;
use App\Models\PersonalInformation;

use App\Http\Controllers\Admin\Accounts\BlockedController;

use Illuminate\Support\Facades\Crypt;

class PatientController extends Controller
{
    public function get_patient_list(){
        $accounts = Accounts::from('accounts as acc')
            ->join('personal_information as pi', 'acc.acc_id', 'pi.acc_id')
            ->where('acc.acc_is_verified', 1)
            ->where('acc.acc_is_blocked', 0)
            ->where('pi.pi_classification', '!=', 'infirmary personnel')
            ->select('acc.acc_id', 'pi.pi_personal_email', 'pi.pi_gsuite_email', 'pi.pi_classification', 'pi.pi_position', 'acc.acc_created_date')
            ->get();

        $records = array();
        foreach($accounts as $acc){
            $rows = array();
            $rows['acc_id'] = sprintf("%05d",$acc->acc_id);
            $rows['acc_profile_pic'] = '<img class="rounded-circle table-img" src="'.asset('assets/photos/default-profile.jpg').'">';
            $rows['acc_name'] = ucwords("Name here");
    
            if($acc->pi_gsuite_email && $acc->pi_personal_email){
                $rows['acc_email'] = 
                '<ul>
                    <li>'.$acc->pi_gsuite_email.'</li>
                    <li>'.$acc->pi_personal_email.'</li>
                </ul>';
            }
            else{
                $rows['acc_email'] =
                '<ul>
                    <li>'.(($acc->pi_gsuite_email) ? $acc->pi_gsuite_email : $acc->pi_personal_email).'</li>
                </ul>';
            }

            $rows['acc_department'] = 'dept';
            $rows['acc_program'] = 'program';
            $rows['acc_year_level'] = 'year level';
           
            $rows['acc_position'] = ucwords($acc->pi_position);
            $rows['acc_classification'] = ucwords($acc->pi_classification);
            $rows['acc_join_date'] = date_format(date_create($acc->acc_created_date), 'M d, Y');

            $update = '<button type="button" class="btn btn-primary btn-sm" id="view_btn_'.$acc->acc_id.'" onclick="view(`#view_btn_'.$acc->acc_id.'`,`'.Crypt::encrypt($acc->acc_id).'`)"><label>View</label></button>';
            $delete = '<button type="button" class="btn btn-danger btn-sm" id="block_btn_'.$acc->acc_id.'" onclick="block(`#block_btn_'.$acc->acc_id.'`,`'.$acc->acc_id.'`)"><label>Block</label></button>';
            $rows['action'] = $update." ".$delete;
            $records[] = $rows;
        }

        $output = array(
            "data" => $records
        );

        echo json_encode($output);
    }

    public function index(){
        return view('Main.Admin.Accounts.Patient');
    }
}
