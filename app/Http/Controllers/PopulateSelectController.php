<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Storage;

use App\Models\ER_MedicalRequestSlip;

class PopulateSelectController extends Controller
{
    public function provinces($reg_id="all", $selected_id, $is_select_element=true){
        $provinces = null;
        $result = null;

        if($reg_id == "all"){
            $provinces = DB::table('ref_add_prov')
            ->orderBy('prov_name','ASC')
            ->get();
        }
        else{
            $provinces = DB::table('ref_add_prov')
            ->where('reg_id', $reg_id)
            ->orderBy('prov_name','ASC')
            ->get();
        }

        if($is_select_element ){
            foreach($provinces as $prov){
                $result .= "<option value='".$prov->prov_id."' ".(($selected_id==$prov->prov_id) ? "selected" : '').">".$prov->prov_name."</option>";
            }
        }
        else{
            $result = json_encode($provinces);
        }   
          
        return $result;
    }

    public function municipalities($prov_id, $selected_id, $is_select_element=true){
        $result = null;
        
        $municipalities = DB::table('ref_add_mun')
        ->where('prov_id', $prov_id)
        ->orderBy('mun_name','ASC')
        ->get();

        if($is_select_element){
            foreach($municipalities as $mun){
                $result .= "<option value='".$mun->mun_id."' ".(($selected_id==$mun->mun_id) ? "selected" : '').">".$mun->mun_name."</option>";
            }
        }
        else{
            $result = json_encode($municipalities);
        }   
          
        return $result;
    }

    public function barangays($mun_id, $selected_id, $is_select_element=true){
        $result = null;
        
        $barangays = DB::table('ref_add_brgy')
        ->where('mun_id', $mun_id)
        ->orderBy('brgy_name','ASC')
        ->get();

        if($is_select_element){
            foreach($barangays as $brgy){
                $result .= "<option value='".$brgy->brgy_id."' ".(($selected_id==$brgy->brgy_id) ? "selected" : '').">".$brgy->brgy_name."</option>";
            }
        }
        else{
            $result = json_encode($barangays);
        }   
          
        return $result;
    }

    public function departments($grade_level, $selected_id, $is_select_element=true){
        $result = null;
        
        // grade_level legend:
        // 1 = elementary 
        // 2 = junior high 
        // 3 = senior high 
        // 4 = college
        if(in_array($grade_level, ['grade 11', 'grade 12'])){
            $departments = DB::table('department')
            ->where('gl_id', 3)
            ->orderBy('dept_name','ASC')
            ->get();
        }
        else if(in_array($grade_level, ['1st year (college)', '2nd year (college)', '3rd year (college)', '4th year (college)'])){
            $departments = DB::table('department')
            ->where('gl_id', 4)
            ->orderBy('dept_name','ASC')
            ->get();
        }
        else if($grade_level == 'all'){
            $departments = DB::table('department')
            ->orderBy('dept_name','ASC')
            ->get();
        }
        else{
            $departments = DB::table('department')
            ->where('gl_id', 2)
            ->orderBy('dept_name','ASC')
            ->get();
        }

        if($is_select_element){
            foreach($departments as $dept){
                $result .= "<option value='".$dept->dept_id."' ".(($selected_id==$dept->dept_id) ? "selected" : '').">".$dept->dept_code."</option>";
            }
        }
        else{
            $result = json_encode($departments);
        }   
          
        return $result;
    }

    public function programs($dept_id, $selected_id, $is_select_element=true){
        $result = null;

        $programs = DB::table('program')
        ->where('dept_id', $dept_id)
        ->orderBy('prog_name','ASC')
        ->get();

        if($is_select_element){
            foreach($programs as $prog){
                $result .= "<option value='".$prog->prog_id."' ".(($selected_id==$prog->prog_id) ? "selected" : '').">".$prog->prog_code."</option>";
            }
        }
        else{
            $result = json_encode($departments);
        }   
          
        return $result;
    }  
    
    public function religions($selected_id, $is_select_element=true){
        $result=null;

        $religions = DB::table('ref_religion')
        ->orderBy('rlgn_name','ASC')
        ->where('rlgn_id', '!=', 1)
        ->get();

        if($is_select_element){
            foreach($religions as $rlgn){
                $result .= "<option value='".$rlgn->rlgn_id."' ".(($selected_id==$rlgn->rlgn_id) ? "selected" : '').">".$rlgn->rlgn_name."</option>";
            }
            $result .= "<option value='1' ".(($selected_id==1) ? "selected" : '').">Others</option>";
        }
        else{
            $religions = json_decode($religions);
            array_push($religions, ['rlgn_id'=>1, 'rlgn_name'=>'Others']);
            $result = json_encode($religions);
        }   
          
        return $result;
    }

    public function pdf(){  
        $data = ER_MedicalRequestSlip::where('mrs_id', '7')->first();

        $pdf = PDF::loadView('Forms.MedicalRequestSlip', compact('data'));
        $pdf->setPaper('letter', 'portrait');
        // $content = $pdf->download()->getOriginalContent();

        // Storage::put('public/generated_documents/'.$filename.'.pdf', $content)
        return $pdf->stream('temp.pdf');
        // if(Storage::put('public/generated_documents/'.$filename.'.pdf', $content)){
        //     $response = [
        //         'status' => 200,
        //         'filename' => $filename.'.pdf'
        //     ];
        // }
        // else{
        //     $response = [
        //         'title' => 'Error!',
        //         'message' => 'Unable to generate PDF, try again later.',
        //         'icon' => 'error',
        //         'status' => 400
        //     ];
        // }

        // echo json_encode($response);
    }
}
