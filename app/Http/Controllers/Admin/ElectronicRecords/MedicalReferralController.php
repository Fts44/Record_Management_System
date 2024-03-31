<?php

namespace App\Http\Controllers\Admin\ElectronicRecords;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\ElectronicRecord;
use App\Models\ER_MedicalReferral;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Session;

class MedicalReferralController extends Controller
{
    public function details(Request $request){
        $mr_id = Crypt::decrypt($request->mr_id);
        $mr = ER_MedicalReferral::where('mr_id', $mr_id)->first();

        $response = [
            'title' => 'Success!',
            'status' => 200,
            'data' => [
                'mr' => $mr_id,
                'date' => $mr->mr_date,
                'patient_name' => $mr->mr_patient_name,
                'age' => $mr->mr_age,
                'sex' => $mr->mr_sex,
                'department' => $mr->dept_id,
                'program' => $mr->prog_id,
                'to' =>$mr->mr_to,
                'evaluation_type' =>$mr->mr_evaluation_type
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
            'department' => ['required'],
            'program' => ['nullable'],
            'to' => ['required'],
            'evaluation_type' => ['required']
        ];

        $messages = [
            
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Medical Referral Not Created.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            $mr = new ER_MedicalReferral;
            $mr->mr_date = $request->date;
            $mr->mr_patient_name = $request->patient_name;
            $mr->mr_age = $request->age;
            $mr->mr_sex = $request->sex;
            $mr->dept_id = $request->department;
            $mr->prog_id = $request->program;
            $mr->mr_to = $request->to;
            $mr->mr_evaluation_type = $request->evaluation_type;
            
            if($mr->save()){
                $patient_id = Crypt::decrypt($request->acc_id);
                $physician_id = Crypt::decrypt(Session::get('hsp_user_data')['acc_id']);

                $er = new ElectronicRecord;
                // $er->er_control_no = $request->control_no;
                $er->er_created_date = Carbon::now();
                $er->er_doc_last_update = NULL;
                $er->er_doc_org_id = $mr->getKey();
                $er->dt_id = 5; // 5 is for medical referral, refer to the documet_type table
                $er->patient_id = $patient_id;
                $er->physician_id = $physician_id;
                $er->save();
            }   

            $response = [
                'title' => 'Success!',
                'message' => 'Medical Referral Created. ',
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
            'department' => ['required'],
            'program' => ['nullable'],
            'to' => ['required'],
            'evaluation_type' => ['required']
        ];

        $messages = [
            
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Medical Referral Not Updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            $mr_id = Crypt::decrypt($request->mr_id);
            $mr = ER_MedicalReferral::where('mr_id', $mr_id)->first();

            $mr->mr_date = $request->date;
            $mr->mr_patient_name = $request->patient_name;
            $mr->mr_age = $request->age;
            $mr->mr_sex = $request->sex;
            $mr->dept_id = $request->department;
            $mr->prog_id = $request->program;
            $mr->mr_to = $request->to;
            $mr->mr_evaluation_type = $request->evaluation_type;

            if($mr->save()){
                $er = ElectronicRecord::from('electronic_record as er')
                    ->join('document_type as dt', 'er.dt_id', 'dt.dt_id')
                    ->join('medical_referral as mr', 'er.er_doc_org_id', 'mr.mr_id')
                    ->where('dt.dt_id', 5) // five is for medical referral
                    ->where('er.er_doc_org_id', $mr_id)
                    ->first();
                $er->er_doc_last_update = Carbon::now();
                $er->save();
            }   

            $response = [
                'title' => 'Success!',
                'message' => 'Medical Referral Updated. ',
                'icon' => 'success',
                'status' => 200,
            ]; 
        }
        
        return json_encode($response);
    }

    public function delete(Request $request){
        $mr_id = Crypt::decrypt($request->mr_id);

        try{
            $mr = ER_MedicalReferral::where('mr_id', $mr_id)->delete();
            $er = ElectronicRecord::where('er_doc_org_id', $mr_id)
                ->where('dt_id', 5) // dt_id 5 = medical referral
                ->delete();

            $response = [
                'title' => 'Success!',
                'message' => 'Medical Referral Deleted.',
                'icon' => 'success',
                'status' => 200
            ]; 
        }
        catch(Exception $e){
            $response = [
                'title' => 'Failed!',
                'message' => 'Medical Referral Not Deleted.',
                'icon' => 'error',
                'status' => 400
            ]; 
        }

        return json_encode($response);
    }
}
