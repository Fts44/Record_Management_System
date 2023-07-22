<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Accounts;
use App\Models\PersonalInformation;
use App\Models\EmergencyContact;
use App\Models\ElectronicRecord;
use App\Models\DocumentType;

use Illuminate\Support\Facades\Crypt;
use PDF;

class AccountDetailsController extends Controller
{
    public function get_user_data($acc_id){
        $acc = Accounts::from('accounts as acc')
            ->select(
                'acc.*', 'pi.*', 'rp.*', 'rm.*', 'rb.*', 'dept.*', 'prog.*', 'rr.*',
                'ec.*', 'ecrp.prov_name as ec_prov', 'ecrm.mun_name as ec_mun', 'ecrb.brgy_name as ec_brgy'
            )
            ->where('acc.acc_id', $acc_id)

            // personal information
            ->join('personal_information as pi', 'acc.acc_id', 'pi.acc_id')
            ->leftjoin('address as addr', 'pi.add_id', 'addr.add_id')
            ->leftjoin('ref_add_prov as rp', 'addr.prov_id', 'rp.prov_id')
            ->leftjoin('ref_add_mun as rm', 'addr.mun_id', 'rm.mun_id')
            ->leftjoin('ref_add_brgy as rb', 'addr.brgy_id', 'rb.brgy_id')
            ->leftjoin('department as dept', 'pi.dept_id', 'dept.dept_id')
            ->leftjoin('program as prog', 'pi.prog_id', 'prog.prog_id')
            ->leftjoin('ref_religion as rr', 'pi.rlgn_id', 'rr.rlgn_id')
            
            // emergency contact details
            ->leftjoin('emergency_contact as ec', 'pi.ec_id', 'ec.ec_id')
            ->leftjoin('address as ecaddr', 'ec.add_id', 'ecaddr.add_id')
            ->leftjoin('ref_add_prov as ecrp', 'ecaddr.prov_id', 'rp.prov_id')
            ->leftjoin('ref_add_mun as ecrm', 'ecaddr.mun_id', 'rm.mun_id')
            ->leftjoin('ref_add_brgy as ecrb', 'ecaddr.brgy_id', 'rb.brgy_id')

            ->first();
            
        return $acc;
    }

    public function index(Request $request){
        $acc = $this->get_user_data(Crypt::decrypt($request->acc_id));
  
        // $pdf = PDF::loadView('Forms.MedicalRequestSlip', compact('acc'));
        // $pdf->set_option('isHtml5ParserEnabled', true);
        // $pdf->set_paper(array(0, 0, 612.00, 792.00), 'portrait');
        // return $pdf->stream();

        // return view('Forms.MedicalRequestSlip', compact('acc'));
        return view('Main.Admin.Accounts.AccountDetails', compact('acc'));
    }
}
