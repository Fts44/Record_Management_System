<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DB;
use Session;

use App\Models\PersonalInformation;
use App\Models\EmergencyContact;
use App\Models\Address;

use App\Http\Controllers\PopulateSelectController;

class EmergencyContactController extends Controller
{
    public function get_emergency_contact_data(){
        $acc_id = Crypt::decrypt(Session::get('hsp_user_data')['acc_id']);

        $acc = EmergencyContact::from('emergency_contact as ec')
            ->select('ec.*', 'rp.*', 'rm.*', 'rb.*')
            ->where('pi.acc_id', $acc_id)
            ->join('personal_information as pi', 'ec.ec_id', 'pi.ec_id')
            ->leftjoin('address as addr', 'ec.add_id', 'addr.add_id')
            ->leftjoin('ref_add_prov as rp', 'addr.prov_id', 'rp.prov_id')
            ->leftjoin('ref_add_mun as rm', 'addr.mun_id', 'rm.mun_id')
            ->leftjoin('ref_add_brgy as rb', 'addr.brgy_id', 'rb.brgy_id')
            ->first();
        
        return $acc;
    }
    
    public function index(){
        $ec = $this->get_emergency_contact_data();

        $this->PopulateSelect = new PopulateSelectController;

        $provinces = $this->PopulateSelect->provinces("all", $ec->prov_id, true);
        $municipalities = $this->PopulateSelect->municipalities($ec->prov_id, $ec->mun_id, true);
        $barangays = $this->PopulateSelect->barangays($ec->mun_id, $ec->brgy_id, true);

        return view('Main.Patient.Settings.EmergencyContact')
            ->with([
                'ec' => $ec,
                'provinces' => $provinces,
                'municipalities' => $municipalities,
                'barangays' => $barangays
            ]);
    }

    public function update(Request $request){

        $rules = [
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'contact_number' => 'required',
            'telephone_number' => 'nullable',
            'relationship' => 'required',
            'province' => 'required',
            'city' => 'required',
            'barangay' => 'required',
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

                $ec = EmergencyContact::from('emergency_contact as ec')
                    ->select('ec.*')
                    ->where('pi.acc_id', $acc_id)
                    ->join('personal_information as pi', 'ec.ec_id', 'pi.ec_id')
                    ->first();

                $add = Address::where('add_id', $ec->add_id)->first();
        
                // if ec query is empty, create new insert emergency_contact query
                if(!$ec){
                    $ec = new EmergencyContact;
                }
                  
                // if ec_add_id query is null, create new insert address
                if(!$ec->add_id){
                    $add = new Address;
                }

                $add->prov_id = $request->province;
                $add->mun_id = $request->city;
                $add->brgy_id = $request->barangay;
                $add->save();

                $ec->ec_firstname = $request->first_name;
                $ec->ec_middlename = $request->middle_name;
                $ec->ec_lastname = $request->last_name;
                $ec->ec_contact_no = $request->contact_number;
                $ec->ec_telephone_no = $request->telephone_number;
                $ec->ec_relationship = $request->relationship;
                $ec->add_id = $add->getKey();
                $ec->save();
        
                $acc = PersonalInformation::where('acc_id', $acc_id)->first();
                $acc->ec_id = $ec->getKey();
                $acc->save();

                $response = [
                    'title' => 'Success!',
                    'message' => 'Emergency Contact Updated. ',
                    'icon' => 'success',
                    'status' => 200
                ];
            }
            catch(\Exception $e){
                $response = [
                    'title' => 'Failed!',
                    'message' => 'Failed saving data. '.$e->getMessage(),
                    'icon' => 'error',
                    'status' => 400
                ];
            }
        }
        echo json_encode($response);
    }
}
