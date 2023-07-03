<?php

namespace App\Http\Controllers\Admin\ElectronicRecords;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\ElectronicRecord;
use App\Models\ER_MedicalRequestSlip;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Session;

class MedicalRequestSlipController extends Controller
{
    public function details(Request $request){
        $mrs_id = Crypt::decrypt($request->mrs_id);
        $mrs = ER_MedicalRequestSlip::where('mrs_id', $mrs_id)->first();

        $response = [
            'title' => 'Success!',
            'status' => 200,
            'data' => [
                'mrs_id' => $mrs_id,
                'patient_name' => $mrs->mrs_patient_name,
                'date' => $mrs->mrs_date,
                'age' => $mrs->mrs_age,
                'sex' => $mrs->mrs_sex,
                'requested_by' =>$mrs->mrs_requested_by,
                'chest_xray' =>$mrs->mrs_chest_xray,
                'cbc' =>$mrs->mrs_cbc,
                'urinalysis' =>$mrs->mrs_urinalysis,
                'fecalysis' =>$mrs->mrs_fecalysis,
                'drug_test' =>$mrs->mrs_drug_test,
                'blood_typing' =>$mrs->mrs_blood_typing,
                'others' =>$mrs->mrs_others,
            ]
        ]; 

        echo json_encode($response);
    }

    public function create(Request $request){

        $rules = [
            'patient_name' => ['required'],
            'date' => ['required'],
            'age' => ['required', 'numeric'],
            'sex' => ['required', 'in:male,female'],
            'requested_by' => ['required'],
            'chest_xray' => ['nullable'],
            'cbc' => ['nullable'],
            'urinalysis' => ['nullable'],
            'fecalysis' => ['nullable'],
            'drug_test' => ['nullable'],
            'blood_typing' => ['nullable'],
            'others' => ['required_without_all:chest_xray,cbc,urinalysis,fecalysis,drug_test,blood_typing'],
        ];

        $messages = [
            'others.required_without_all' => 'This field is required if no checkbox is selected.'
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Medical Request Slip Not Created.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            $mrs = new ER_MedicalRequestSlip;
            $mrs->mrs_patient_name = $request->patient_name;
            $mrs->mrs_date = $request->date;
            $mrs->mrs_age = $request->age;
            $mrs->mrs_sex = $request->sex;
            $mrs->mrs_requested_by = $request->requested_by;
            $mrs->mrs_chest_xray = $request->chest_xray ? 1 : 0;
            $mrs->mrs_cbc = $request->cbc ? 1 : 0;
            $mrs->mrs_urinalysis = $request->urinalysis ? 1 : 0;
            $mrs->mrs_fecalysis = $request->fecalysis ? 1 : 0;
            $mrs->mrs_drug_test = $request->drug_test ? 1 : 0;
            $mrs->mrs_blood_typing = $request->blood_typing ? 1 : 0;
            $mrs->mrs_others = $request->others;
            
            if($mrs->save()){
                $patient_id = Crypt::decrypt($request->acc_id);
                $physician_id = Crypt::decrypt(Session::get('hsp_user_data')['acc_id']);

                $er = new ElectronicRecord;
                $er->er_created_date = Carbon::now();
                $er->er_doc_last_update = NULL;
                $er->er_doc_org_id = $mrs->getKey();
                $er->dt_id = 1; // 1 is for medical request slip, refer to the documet_type table
                $er->patient_id = $patient_id;
                $er->physician_id = $physician_id;
                $er->save();
            }   

            $response = [
                'title' => 'Success!',
                'message' => 'Meidcal Request Slip Created. ',
                'icon' => 'success',
                'status' => 200,
            ]; 
        }

        echo json_encode($response);
    }

    public function update(Request $request){
        $rules = [
            'patient_name' => ['required'],
            'date' => ['required'],
            'age' => ['required', 'numeric'],
            'sex' => ['required', 'in:male,female'],
            'requested_by' => ['required'],
            'chest_xray' => ['nullable'],
            'cbc' => ['nullable'],
            'urinalysis' => ['nullable'],
            'fecalysis' => ['nullable'],
            'drug_test' => ['nullable'],
            'blood_typing' => ['nullable'],
            'others' => ['required_without_all:chest_xray,cbc,urinalysis,fecalysis,drug_test,blood_typing'],
        ];

        $messages = [
            'others.required_without_all' => 'This field is required if no checkbox is selected.'
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Meidcal Request Slip Not Updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            $mrs_id = Crypt::decrypt($request->mrs_id);
            $mrs = ER_MedicalRequestSlip::where('mrs_id', $mrs_id)->first();

            $mrs->mrs_patient_name = $request->patient_name;
            $mrs->mrs_date = $request->date;
            $mrs->mrs_age = $request->age;
            $mrs->mrs_sex = $request->sex;
            $mrs->mrs_requested_by = $request->requested_by;
            $mrs->mrs_chest_xray = $request->chest_xray ? 1 : 0;
            $mrs->mrs_cbc = $request->cbc ? 1 : 0;
            $mrs->mrs_urinalysis = $request->urinalysis ? 1 : 0;
            $mrs->mrs_fecalysis = $request->fecalysis ? 1 : 0;
            $mrs->mrs_drug_test = $request->drug_test ? 1 : 0;
            $mrs->mrs_blood_typing = $request->blood_typing ? 1 : 0;
            $mrs->mrs_others = $request->others;
            
            if($mrs->save()){
                $er = $er = ElectronicRecord::from('electronic_record as er')
                    ->join('document_type as dt', 'er.dt_id', 'dt.dt_id')
                    ->join('medical_request_slip as mrs', 'er.er_doc_org_id', 'mrs.mrs_id')
                    ->where('dt.dt_id', 1) // one is for medical request slip
                    ->where('er.er_doc_org_id', $mrs_id)
                    ->first();
                $er->er_doc_last_update = Carbon::now();
                $er->save();
            }   

            $response = [
                'title' => 'Success!',
                'message' => 'Meidcal Request Slip Updated. ',
                'icon' => 'success',
                'status' => 200,
            ]; 
        }
        
        echo json_encode($response);
    }

    public function delete(Request $request){
        $mrs_id = Crypt::decrypt($request->mrs_id);

        try{
            $mrs = ER_MedicalRequestSlip::where('mrs_id', $mrs_id)->delete();
            $er = ElectronicRecord::where('er_doc_org_id', $mrs_id)
                ->where('dt_id', 1) // dt_id 1 = medical request sliip
                ->delete();

            $response = [
                'title' => 'Success!',
                'message' => 'Medical Requset Slip Deleted.',
                'icon' => 'success',
                'status' => 200
            ]; 
        }
        catch(Exception $e){
            $response = [
                'title' => 'Failed!',
                'message' => 'Medical Requset Slip Not Deleted.',
                'icon' => 'error',
                'status' => 400
            ]; 
        }

        echo json_encode($response);
    }
}
