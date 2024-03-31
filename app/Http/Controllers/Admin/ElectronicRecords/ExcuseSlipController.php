<?php

namespace App\Http\Controllers\Admin\ElectronicRecords;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\ElectronicRecord;
use App\Models\ER_ExcuseSlip;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Session;

class ExcuseSlipController extends Controller
{
    public function details(Request $request){
        $es_id = Crypt::decrypt($request->es_id);
        $es = ER_ExcuseSlip::where('es_id', $es_id)->first();

        $response = [
            'title' => 'Success!',
            'status' => 200,
            'data' => [
                'es' => $es_id,
                'patient_name' => $es->es_patient_name,
                'date' => $es->es_date,
                'age' => $es->es_age,
                'department' => $es->dept_id,
                'program' => $es->prog_id,
                'authorized_by' =>$es->es_authorized_by,
                'complaints' =>$es->es_complaints,
                'diagnosis' =>$es->es_diagnosis
            ]
        ]; 

        return json_encode($response);
    }

    public function create(Request $request){
        $rules = [
            'patient_name' => ['required'],
            'date' => ['required'],
            'age' => ['required', 'numeric'],
            'department' => ['required'],
            'program' => ['nullable'],
            'authorized_by' => ['required'],
            'complaints' => ['required'],
            'diagnosis' => ['required']
        ];

        $messages = [
            
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Excuse Slip Not Created.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            $es = new ER_ExcuseSlip;
            $es->es_patient_name = $request->patient_name;
            $es->es_date = $request->date;
            $es->es_age = $request->age;
            $es->dept_id = $request->department;
            $es->prog_id = $request->program;
            $es->es_authorized_by = $request->authorized_by;
            $es->es_complaints = $request->complaints;
            $es->es_diagnosis = $request->diagnosis;
            
            if($es->save()){
                $patient_id = Crypt::decrypt($request->acc_id);
                $physician_id = Crypt::decrypt(Session::get('hsp_user_data')['acc_id']);

                $er = new ElectronicRecord;
                // $er->er_control_no = $request->control_no;
                $er->er_created_date = Carbon::now();
                $er->er_doc_last_update = NULL;
                $er->er_doc_org_id = $es->getKey();
                $er->dt_id = 3; // 2 is for excuse slip, refer to the documet_type table
                $er->patient_id = $patient_id;
                $er->physician_id = $physician_id;
                $er->save();
            }   

            $response = [
                'title' => 'Success!',
                'message' => 'Excuse Slip Created. ',
                'icon' => 'success',
                'status' => 200,
            ]; 
        }

        return json_encode($response);
    }

    public function update(Request $request){

        $rules = [
            'patient_name' => ['required'],
            'date' => ['required'],
            'age' => ['required', 'numeric'],
            'department' => ['required'],
            'program' => ['nullable'],
            'authorized_by' => ['required'],
            'complaints' => ['required'],
            'diagnosis' => ['required']
        ];

        $messages = [
            
        ];

        $validator = Validator::make( $request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Excuse Slip Not Updated.',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages()
            ]; 
        }
        else{
            $es_id = Crypt::decrypt($request->es_id);
            $es = ER_ExcuseSlip::where('es_id', $es_id)->first();

            $es->es_patient_name = $request->patient_name;
            $es->es_date = $request->date;
            $es->es_age = $request->age;
            $es->dept_id = $request->department;
            $es->prog_id = $request->program;
            $es->es_authorized_by = $request->authorized_by;
            $es->es_complaints = $request->complaints;
            $es->es_diagnosis = $request->diagnosis;

            if($es->save()){
                $er = ElectronicRecord::from('electronic_record as er')
                    ->join('document_type as dt', 'er.dt_id', 'dt.dt_id')
                    ->join('excuse_slip as es', 'er.er_doc_org_id', 'es.es_id')
                    ->where('dt.dt_id', 3) // three is for excuse slip
                    ->where('er.er_doc_org_id', $es_id)
                    ->first();
                $er->er_doc_last_update = Carbon::now();
                $er->save();
            }   

            $response = [
                'title' => 'Success!',
                'message' => 'Excuse Slip Updated. ',
                'icon' => 'success',
                'status' => 200,
            ]; 
        }
        
        return json_encode($response);
    }

    public function delete(Request $request){

        $es_id = Crypt::decrypt($request->es_id);

        try{
            $es = ER_ExcuseSlip::where('es_id', $es_id)->delete();
            $er = ElectronicRecord::where('er_doc_org_id', $es_id)
                ->where('dt_id', 3) // dt_id 3 = excuse sliip
                ->delete();

            $response = [
                'title' => 'Success!',
                'message' => 'Excuse Slip Deleted.',
                'icon' => 'success',
                'status' => 200
            ]; 
        }
        catch(Exception $e){
            $response = [
                'title' => 'Failed!',
                'message' => 'Excuse Slip Not Deleted.',
                'icon' => 'error',
                'status' => 400
            ]; 
        }

        return json_encode($response);
    }
}
