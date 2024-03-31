<?php

namespace App\Http\Controllers\Admin\ElectronicRecords;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\ElectronicRecord;
use App\Models\ER_MedicalCertificate;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Session;

class MedicalCertificateController extends Controller
{
    public function details(Request $request){
        $mc_id = Crypt::decrypt($request->mc_id);
        $mc = ER_MedicalCertificate::from('medical_certificate as mc')
            ->where('mc.mc_id', $mc_id)
            ->where('er.dt_id', '4')
            ->leftjoin('electronic_record as er', 'er.er_doc_org_id', 'mc.mc_id')  
            ->first();

        $response = [
            'title' => 'Success!',
            'status' => 200,
            'data' => [
                'control_no' => $mc->er_control_no,
                'date' => $mc->mc_date,
                'patient_name' => $mc->mc_patient_name,
                'age' => $mc->mc_age,
                'sex' => $mc->mc_sex,
                'civil_status' => $mc->mc_civil_status,
                'address' => $mc->mc_address,
                'date_examined' => $mc->mc_date_examined,
                'diagnosis' => $mc->mc_diagnosis,
                'remarks' => $mc->mc_remarks,
                'purpose' => $mc->mc_purpose,
            ]
        ]; 

        return json_encode($response);
    }

    public function create(Request $request){
        $rules = [
            'date' => ['required'],
            'patient_name' => ['required'],
            'age' => ['required', 'numeric'],
            'sex' => ['required', 'in:male,female'],
            'civil_status' => ['required', 'in:single,married,separated,widowed'],
            'date_examined' => ['required'],
            'address' => ['required'],
            'diagnosis' => ['required'],
            'remarks' => ['required'],
            'purpose' => ['required']
        ];

        $messages = [
            
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Medical Certificate Not Created.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            $mc = new ER_MedicalCertificate;
            $mc->mc_date = $request->date;
            $mc->mc_patient_name = $request->patient_name;
            $mc->mc_age = $request->age;
            $mc->mc_sex = $request->sex;
            $mc->mc_civil_status = $request->civil_status;
            $mc->mc_date_examined = $request->date_examined;
            $mc->mc_address = $request->address;
            $mc->mc_diagnosis = $request->diagnosis;
            $mc->mc_remarks = $request->remarks;
            $mc->mc_purpose = $request->purpose;
            
            if($mc->save()){
                $patient_id = Crypt::decrypt($request->acc_id);
                $physician_id = Crypt::decrypt(Session::get('hsp_user_data')['acc_id']);

                $er = new ElectronicRecord;
                $er->er_control_no = $request->control_no;
                $er->er_created_date = Carbon::now();
                $er->er_doc_last_update = NULL;
                $er->er_doc_org_id = $mc->getKey();
                $er->dt_id = 4; // 4 is for medical certificate, refer to the documet_type table
                $er->patient_id = $patient_id;
                $er->physician_id = $physician_id;
                $er->save();
            }   

            $response = [
                'title' => 'Success!',
                'message' => 'Medical Certificate Created. ',
                'icon' => 'success',
                'status' => 200,
            ]; 
        }

        return json_encode($response);
    }

    public function update(Request $request){
        $rules = [
            'date' => ['required'],
            'patient_name' => ['required'],
            'age' => ['required', 'numeric'],
            'sex' => ['required', 'in:male,female'],
            'civil_status' => ['required', 'in:single,married,separated,widowed'],
            'date_examined' => ['required'],
            'address' => ['required'],
            'diagnosis' => ['required'],
            'remarks' => ['required'],
            'purpose' => ['required']
        ];

        $messages = [
            
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Medical Certificate Not Created.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            $mc_id = Crypt::decrypt($request->mc_id);
            $mc = ER_MedicalCertificate::where('mc_id', $mc_id)->first();

            $mc->mc_date = $request->date;
            $mc->mc_patient_name = $request->patient_name;
            $mc->mc_age = $request->age;
            $mc->mc_sex = $request->sex;
            $mc->mc_civil_status = $request->civil_status;
            $mc->mc_date_examined = $request->date_examined;
            $mc->mc_address = $request->address;
            $mc->mc_diagnosis = $request->diagnosis;
            $mc->mc_remarks = $request->remarks;
            $mc->mc_purpose = $request->purpose;
            
            if($mc->save()){
                $er = ElectronicRecord::from('electronic_record as er')
                    ->join('document_type as dt', 'er.dt_id', 'dt.dt_id')
                    ->join('medical_certificate as mc', 'er.er_doc_org_id', 'mc.mc_id')
                    ->where('dt.dt_id', 4) // 4 is for medical certificate
                    ->where('er.er_doc_org_id', $mc_id)
                    ->first();

                $er->er_control_no = $request->control_no;
                $er->er_doc_last_update = Carbon::now();
                // $er->save();    
            }   

            $response = [
                'title' => 'Success!',
                'message' => 'Medical Certificate Updated. ',
                'icon' => 'success',
                'status' => 200,
            ]; 
        }
        
        return json_encode($response);
    }

    public function delete(Request $request){
        $mc_id = Crypt::decrypt($request->mc_id);

        try{
            $mc = ER_MedicalCertificate::where('mc_id', $mc_id)->delete();
            $er = ElectronicRecord::where('er_doc_org_id', $mc_id)
                ->where('dt_id', 4) // dt_id 4 = medical certificate
                ->delete();

            $response = [
                'title' => 'Success!',
                'message' => 'Medical Certificate Deleted.',
                'icon' => 'success',
                'status' => 200
            ]; 
        }
        catch(Exception $e){
            $response = [
                'title' => 'Failed!',
                'message' => 'Medical Certificate Not Deleted.',
                'icon' => 'error',
                'status' => 400
            ]; 
        }

        return json_encode($response);
    }
}
