<?php

namespace App\Http\Controllers\Admin\ElectronicRecords;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\ElectronicRecord;
use App\Models\ER_DentalCertificate;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Session;


class DentalCertificateController extends Controller
{
    public function details(Request $request){
        $dc_id = Crypt::decrypt($request->dc_id);
        $dc = ER_DentalCertificate::from('dental_certificate as dc')
            ->where('dc.dc_id', $dc_id)
            ->where('er.dt_id', '2')
            ->leftjoin('electronic_record as er', 'er.er_doc_org_id', 'dc.dc_id')        
            ->first();

        $response = [
            'title' => 'Success!',
            'status' => 200,
            'data' => [
                'control_no' => $dc->er_control_no,
                'patient_name' => $dc->dc_patient_name,
                'date' => $dc->dc_date,
                'age' => $dc->dc_age,
                'sex' => $dc->dc_sex,
                'civil_status' => $dc->dc_civil_status,
                'address' => $dc->dc_address,
                'diagnosis_treatment' => $dc->dc_diagnosis_treatment,
                'remarks' => $dc->dc_remarks,
            ]
        ]; 

        echo json_encode($response);
    }

    public function create(Request $request){

        $rules = [
            'control_no' => ['nullable'],
            'patient_name' => ['required'],
            'date' => ['required'],
            'age' => ['required', 'numeric'],
            'sex' => ['required', 'in:male,female'],
            'civil_status' => ['required', 'in:single,married,separated,widowed'],
            'address' => ['required'],
            'diagnosis_treatment' => ['required'],
            'remarks' => ['required']
        ];

        $messages = [
            
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Dental Certificate Not Created.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            $dc = new ER_DentalCertificate;
            $dc->dc_patient_name = $request->patient_name;
            $dc->dc_date = $request->date;
            $dc->dc_age = $request->age;
            $dc->dc_sex = $request->sex;
            $dc->dc_civil_status = $request->civil_status;
            $dc->dc_address = $request->address;
            $dc->dc_diagnosis_treatment = $request->diagnosis_treatment;
            $dc->dc_remarks = $request->remarks;
            
            if($dc->save()){
                $patient_id = Crypt::decrypt($request->acc_id);
                $physician_id = Crypt::decrypt(Session::get('hsp_user_data')['acc_id']);

                $er = new ElectronicRecord;
                $er->er_control_no = $request->control_no;
                $er->er_created_date = Carbon::now();
                $er->er_doc_last_update = NULL;
                $er->er_doc_org_id = $dc->getKey();
                $er->dt_id = 2; // 2 is for dental certificate, refer to the documet_type table
                $er->patient_id = $patient_id;
                $er->physician_id = $physician_id;
                $er->save();
            }   

            $response = [
                'title' => 'Success!',
                'message' => 'Dental Certificate Created. ',
                'icon' => 'success',
                'status' => 200,
            ]; 
        }

        echo json_encode($response);
    }

    public function update(Request $request){
        $rules = [
            'control_no' => ['nullable'],
            'patient_name' => ['required'],
            'date' => ['required'],
            'age' => ['required', 'numeric'],
            'sex' => ['required', 'in:male,female'],
            'civil_status' => ['required', 'in:single,married,separated,widowed'],
            'address' => ['required'],
            'diagnosis_treatment' => ['required'],
            'remarks' => ['required']
        ];

        $messages = [
            
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Dental Certificate Not Updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            $dc_id = Crypt::decrypt($request->dc_id);
            $dc = ER_DentalCertificate::where('dc_id', $dc_id)->first();

            $dc->dc_patient_name = $request->patient_name;
            $dc->dc_date = $request->date;
            $dc->dc_age = $request->age;
            $dc->dc_sex = $request->sex;
            $dc->dc_civil_status = $request->civil_status;
            $dc->dc_address = $request->address;
            $dc->dc_diagnosis_treatment = $request->diagnosis_treatment;
            $dc->dc_remarks = $request->remarks;
            
            if($dc->save()){
                $er = $er = ElectronicRecord::from('electronic_record as er')
                    ->join('document_type as dt', 'er.dt_id', 'dt.dt_id')
                    ->join('dental_certificate as dc', 'er.er_doc_org_id', 'dc.dc_id')
                    ->where('dt.dt_id', 2) // 2 is for dental certificate
                    ->where('er.er_doc_org_id', $dc_id)
                    ->first();
                $er->er_control_no = $request->control_no;
                $er->er_doc_last_update = Carbon::now();
                $er->save();
            }   

            $response = [
                'title' => 'Success!',
                'message' => 'Dental Certificate Updated. ',
                'icon' => 'success',
                'status' => 200,
            ]; 
        }
        
        echo json_encode($response);
    }

    public function delete(Request $request){
        $dc_id = Crypt::decrypt($request->dc_id);

        try{
            $mrs = ER_DentalCertificate::where('dc_id', $dc_id)->delete();
            $er = ElectronicRecord::where('er_doc_org_id', $dc_id)
                ->where('dt_id', 2) // dt_id 1 = medical request sliip
                ->delete();

            $response = [
                'title' => 'Success!',
                'message' => 'Dental Certificate Deleted.',
                'icon' => 'success',
                'status' => 200
            ]; 
        }
        catch(Exception $e){
            $response = [
                'title' => 'Failed!',
                'message' => 'Dental Certificate Not Deleted.',
                'icon' => 'error',
                'status' => 400
            ]; 
        }

        echo json_encode($response);
    }
}
