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
            ->leftjoin('department as dept', 'pi.dept_id', 'dept.dept_id')
            ->leftjoin('program as prog', 'pi.prog_id', 'prog.prog_id')
            ->where('acc.acc_is_verified', 1)
            ->where('acc.acc_is_blocked', 0)
            ->where('pi.pi_classification', '!=', 'infirmary personnel')
            ->get();

        $records = array();
        foreach($accounts as $acc){
            $rows = array();
            $rows['acc_id'] = sprintf("%05d",$acc->acc_id);
            $rows['acc_profile_pic'] =   '<img class="rounded-circle table-img" src="'.(($acc->pi_photo) ? asset('storage/photos/'.$acc->pi_photo) : asset('assets/photos/default-profile.jpg')).'">';
            
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
                $rows['acc_email'] = '<li>'.($acc->pi_gsuite_email ?: $acc->pi_personal_email).'</li>';
            }

            $rows['acc_department'] = $acc->dept_code ?: 'Not Set';
            $rows['acc_program'] = $acc->prog_code ?: 'Not Set';
            $rows['acc_year_level'] = $acc->pi_grade_level ?: 'Not Set';
           
            $rows['acc_position'] = ucwords($acc->pi_position);
            $rows['acc_classification'] = ucwords($acc->pi_classification);
            $rows['acc_join_date'] = date_format(date_create($acc->acc_created_date), 'M d, Y');


            $view = "<a class='btn btn-primary btn-sm' href='".route('Admin.Accounts.Details.Index', ['acc_id' => Crypt::encrypt($acc->acc_id)])."'>View</a>";
            $delete = '<button type="button" class="btn btn-danger btn-sm" id="block_btn_'.$acc->acc_id.'" onclick="block(`#block_btn_'.$acc->acc_id.'`,`'.$acc->acc_id.'`)"><label>Block</label></button>';
            $rows['action'] = $view." ".$delete;
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
