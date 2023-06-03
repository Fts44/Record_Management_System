<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use DB;
use Session;
use Illuminate\Support\Facades\Crypt;

use App\Models\Accounts;
use App\Models\PersonalInformation;
use App\Models\Address;

use App\Http\Controllers\PopulateSelectController;

class ProfileController extends Controller
{
    public function get_user_data($acc_id){
        $acc_id = Crypt::decrypt(Session::get('hsp_user_data')['acc_id']);

        $acc = Accounts::from('accounts as acc')
            ->select('acc.*', 'pi.*', 'rp.*', 'rm.*')
            ->where('acc.acc_id', $acc_id)
            ->join('personal_information as pi', 'acc.acc_id', 'pi.acc_id')
            ->leftjoin('address as addr', 'pi.add_id', 'addr.add_id')
            ->leftjoin('ref_add_prov as rp', 'addr.prov_id', 'rp.prov_id')
            ->leftjoin('ref_add_mun as rm', 'addr.mun_id', 'rm.mun_id')
            ->leftjoin('ref_add_brgy as rb', 'addr.brgy_id', 'rb.brgy_id')
            ->first();
        
        return $acc;
    }

    public function index(){
        $acc_id = Session::get('hsp_user_data')['acc_id'];
        $acc = $this->get_user_data($acc_id);

        $this->PopulateSelect = new PopulateSelectController;
        $provinces = $this->PopulateSelect->provinces("all", $acc->prov_id, true);
        $municipalities = $this->PopulateSelect->municipalities($acc->prov_id, $acc->mun_id, true);
        $barangays = $this->PopulateSelect->barangays($acc->mun_id, $acc->brgy_id, true);
        $religions = $this->PopulateSelect->religions($acc->rlgn_id, true);

        return view('Main.Patient.Settings.Profile')
            ->with([
                'user' => $acc,
                'provinces' => $provinces,
                'municipalities' => $municipalities,
                'barangays' => $barangays,
                'religions' => $religions,
            ]);
 
    }

    public function update_personal_information(Request $request){

        $rules = [
            // 'profile_picture' => 'required',

            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',

            'sr_code' => 'required',
            // 'personal_email' => 'required',
            // 'gsuite_email' => 'required',

            // 'grade_level' => 'required',
            // 'department' => 'required',
            // 'program' => 'required',

            'birthdate' => 'required',
            'sex' => 'required',
            'civil_status' => 'required',

            // 'religion' => 'required',
            // 'contact_number' => 'required',
            // 'position' => 'required',

            // 'province' => 'required',
            // 'city' => 'required',
            // 'barangay' => 'required',
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
        else{
            
            try{
                $acc_id = Crypt::decrypt(Session::get('hsp_user_data')['acc_id']);
                $acc = PersonalInformation::where('acc_id', $acc_id)->first();
                
                $acc->pi_firstname = $request->first_name;
                $acc->pi_middlename = $request->middle_name;
                $acc->pi_lastname = $request->last_name;
                $acc->pi_srcode = $request->sr_code;
                // emails
                $acc->pi_birthdate = $request->birthdate;
                $acc->pi_sex = $request->sex;
                $acc->pi_civil_status = $request->civil_status;
                // Address
                $acc->save();

                // Updating session data
                $acc_data = Session::get('hsp_user_data');
                $acc_data['first_name'] = Crypt::encrypt($request->first_name);
                $acc_data['middle_name'] = Crypt::encrypt($request->middle_name);
                $acc_data['last_name'] = Crypt::encrypt($request->last_name);
                Session::put('hsp_user_data', $acc_data);

                $response = [
                    'title' => 'Success!',
                    'message' => 'Personal Information Updated.',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(\Exception $e){
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Failel saving data. '.$e->getMessage(),
                    'icon' => 'error',
                    'status' => 400
                ];
            }
        }
        echo json_encode($response);
    }
}
