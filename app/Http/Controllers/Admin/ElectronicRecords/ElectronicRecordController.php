<?php

namespace App\Http\Controllers\Admin\ElectronicRecords;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\ElectronicRecord;
use App\Models\ER_MedicalRequestSlip;

class ElectronicRecordController extends Controller
{
    public function get_record_list(Request $request){
        $acc_id = Crypt::decrypt($request->acc_id);

        $electronic_record = ElectronicRecord::from('electronic_record as er')
            ->select(
                'er.*', 'dt.*', 
                'pi.pi_firstname as phy_firstname',
                'pi.pi_middlename as phy_middlename',
                'pi.pi_lastname as phy_lastname',
            )
            ->join('document_type as dt', 'er.dt_id', 'dt.dt_id')
            ->join('personal_information as pi', 'er.physician_id', 'pi.acc_id')
            ->where('er.patient_id', $acc_id)
            ->get();

        $records = array();
        foreach($electronic_record as $rec){
            $rows = array();
            $rows['er_id'] = 'ER-'.sprintf("%05d",$rec->er_id);
            $rows['er_control_no'] = ($rec->er_control_no) ? $rec->er_control_no : 'Not Set';
            $rows['er_dt_name'] = ucwords($rec->dt_display_name);

            if($rec->phy_firstname){
                $rows['er_physician'] = ucwords($rec->phy_firstname.' '.($rec->phy_middlename ?: '').' '.$rec->phy_lastname);
            }
            else{
                $rows['er_physician'] = ucwords("Not Set");
            }
            
            $rows['er_created_date'] = ($rec->er_created_date) ? date_format(date_create($rec->er_created_date), 'M d, Y h:i a') : 'Not Set';
            $rows['er_doc_last_update'] = ($rec->er_doc_last_update) ? date_format(date_create($rec->er_doc_last_update), 'M d, Y h:i a') : 'Not Set';
            $rows['acc_year_level'] = $rec->pi_grade_level ?: 'Not Set';
           
            $doc_id = Crypt::encrypt($rec->er_doc_org_id);

            if($rec->dt_id=='1'){
                $view = "<button type='button' class='btn btn-secondary btn-sm er_modal-view' 
                        id='medical_request_slip-view-".$doc_id."' 
                        onclick='".'view_form_medical_request_slip("medical_request_slip-view-'.$doc_id.'", "'.$rows['er_id'].'")'."'
                        value='".$doc_id."'>
                            <label><i class='bi bi-search'></i> View</label>
                        </button>";

                $edit = "<button type='button' class='btn btn-primary btn-sm' 
                        id='medical_request_slip-edit-".$doc_id."' 
                        onclick='".'update_form_medical_request_slip("medical_request_slip-edit-'.$doc_id.'", "'.$rows['er_id'].'")'."' 
                        value='".$doc_id."'>
                            <label><i class='bi bi-pencil-square'></i> Edit</label>
                        </button>";

                $delete = "<button type='button' class='btn btn-danger btn-sm medical_request_slip-delete' 
                        id='medical_request_slip-delete-".$doc_id."' 
                        onclick='".'delete_form_medical_request_slip("medical_request_slip-delete-'.$doc_id.'", "'.$rows['er_id'].'")'."' 
                        value='".$doc_id."'>
                            <label><i class='bi bi-trash'></i> Delete</label>
                        </button>";
            }
            else if($rec->dt_id=='2'){
                $view = "<button type='button' class='btn btn-secondary btn-sm er_modal-view' 
                        id='dental_certificate-view-".$doc_id."' 
                        onclick='pdfviewer(1)'
                        value='".$doc_id."'>
                            <label><i class='bi bi-search'></i> View</label>
                        </button>";

                $edit = "<button type='button' class='btn btn-primary btn-sm' 
                        id='dental_certificate-edit-".$doc_id."' 
                        onclick='".'update_form_dental_certificate("dental_certificate-edit-'.$doc_id.'", "'.$rows['er_id'].'")'."' 
                        value='".$doc_id."'>
                            <label><i class='bi bi-pencil-square'></i> Edit</label>
                        </button>";

                $delete = "<button type='button' class='btn btn-danger btn-sm dental_certificate-delete' 
                        id='dental_certificate-delete-".$doc_id."' 
                        onclick='".'delete_form_dental_certificate("dental_certificate-delete-'.$doc_id.'", "'.$rows['er_id'].'")'."' 
                        value='".$doc_id."'>
                            <label><i class='bi bi-trash'></i> Delete</label>
                        </button>";
            }
            else if($rec->dt_id=='3'){
                $view = "<button type='button' class='btn btn-secondary btn-sm er_modal-view' 
                        id='excuse_slip-view-".$doc_id."' 
                        onclick='pdfviewer(1)'
                        value='".$doc_id."'>
                            <label><i class='bi bi-search'></i> View</label>
                        </button>";

                $edit = "<button type='button' class='btn btn-primary btn-sm' 
                        id='excuse_slip-edit-".$doc_id."' 
                        onclick='".'update_form_excuse_slip("excuse_slip-edit-'.$doc_id.'", "'.$rows['er_id'].'")'."' 
                        value='".$doc_id."'>
                            <label><i class='bi bi-pencil-square'></i> Edit</label>
                        </button>";

                $delete = "<button type='button' class='btn btn-danger btn-sm excuse_slip-delete' 
                        id='excuse_slip-delete-".$doc_id."' 
                        onclick='".'delete_form_excuse_slip("excuse_slip-delete-'.$doc_id.'", "'.$rows['er_id'].'")'."' 
                        value='".$doc_id."'>
                            <label><i class='bi bi-trash'></i> Delete</label>
                        </button>";
            }
            else if($rec->dt_id=='4'){
                $view = "<button type='button' class='btn btn-secondary btn-sm er_modal-view' 
                        id='medical_certificate-view-".$doc_id."' 
                        onclick='pdfviewer(1)'
                        value='".$doc_id."'>
                            <label><i class='bi bi-search'></i> View</label>
                        </button>";

                $edit = "<button type='button' class='btn btn-primary btn-sm' 
                        id='medical_certificate-edit-".$doc_id."' 
                        onclick='".'update_form_medical_certificate("medical_certificate-edit-'.$doc_id.'", "'.$rows['er_id'].'")'."' 
                        value='".$doc_id."'>
                            <label><i class='bi bi-pencil-square'></i> Edit</label>
                        </button>";

                $delete = "<button type='button' class='btn btn-danger btn-sm medical_certificate-delete' 
                        id='medical_certificate-delete-".$doc_id."' 
                        onclick='".'delete_form_medical_certificate("medical_certificate-delete-'.$doc_id.'", "'.$rows['er_id'].'")'."' 
                        value='".$doc_id."'>
                            <label><i class='bi bi-trash'></i> Delete</label>
                        </button>";
            }
            else if($rec->dt_id=='5'){
                $view = "<button type='button' class='btn btn-secondary btn-sm er_modal-view' 
                        id='medical_referral-view-".$doc_id."' 
                        onclick='pdfviewer(1)'
                        value='".$doc_id."'>
                            <label><i class='bi bi-search'></i> View</label>
                        </button>";

                $edit = "<button type='button' class='btn btn-primary btn-sm' 
                        id='medical_referral-edit-".$doc_id."' 
                        onclick='".'update_form_medical_referral("medical_referral-edit-'.$doc_id.'", "'.$rows['er_id'].'")'."' 
                        value='".$doc_id."'>
                            <label><i class='bi bi-pencil-square'></i> Edit</label>
                        </button>";

                $delete = "<button type='button' class='btn btn-danger btn-sm medical_referral-delete' 
                        id='medical_referral-delete-".$doc_id."' 
                        onclick='".'delete_form_medical_referral("medical_referral-delete-'.$doc_id.'", "'.$rows['er_id'].'")'."' 
                        value='".$doc_id."'>
                            <label><i class='bi bi-trash'></i> Delete</label>
                        </button>";
            }

            $rows['action'] = $view." ".$edit." ".$delete;
            $records[] = $rows;
        }

        $output = array(
            "data" => $records
        );

        echo json_encode($output);
    }

    public function delete(Request $request){
        $er_id = Crypt::decrypt($request->er_id);
    }

    public function print(Request $request){
        
    }
}
