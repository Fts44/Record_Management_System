<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Validator;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Models\Accounts;
use App\Models\PersonalInformation;
use App\Models\Address;

use App\Rules\GsuiteRule;
use App\Rules\NotGsuiteRule;

use App\Http\Controllers\PopulateSelectController;
use App\Http\Controllers\Authentication\FunctionController as AuthFunction;

class ProfileController extends Controller
{
    public function get_user_data(){
        $acc_id = Crypt::decrypt(Session::get('hsp_user_data')['acc_id']);

        $acc = Accounts::from('accounts as acc')
            ->select('acc.*', 'pi.*', 'rp.*', 'rm.*', 'rb.*')
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
        $acc = $this->get_user_data();

        $this->PopulateSelect = new PopulateSelectController;

        $provinces = $this->PopulateSelect->provinces("all", $acc->prov_id, true);
        $municipalities = $this->PopulateSelect->municipalities($acc->prov_id, $acc->mun_id, true);
        $barangays = $this->PopulateSelect->barangays($acc->mun_id, $acc->brgy_id, true);

        $grade_levels = [
            'daycare', 'kinder', 'grade 1', 'grade 2', 'grade 3', 'grade 4', 'grade 5', 'grade 6', 
            'grade 7', 'grade 8', 'grade 9', 'grade 10',
            'grade 11', 'grade 12',
            '1st year (college)', '2nd year (college)', '3rd year (college)', '4th year (college)'
        ];
        $departments = $this->PopulateSelect->departments(($acc->pi_position=='student') ? $acc->pi_grade_level : 'all', $acc->dept_id, true);
        $programs = $this->PopulateSelect->programs($acc->dept_id, $acc->prog_id, true);

        $religions = $this->PopulateSelect->religions($acc->rlgn_id, true);

        return view('Main.Patient.Settings.Profile')
            ->with([
                'user' => $acc,
                'provinces' => $provinces,
                'municipalities' => $municipalities,
                'barangays' => $barangays,
                'grade_levels' => $grade_levels,
                'departments' => $departments,
                'programs' => $programs,
                'religions' => $religions,
            ]);
            
        // echo json_encode($acc);
    }

    public function update_personal_information(Request $request){
        $old_profile_picture = Crypt::decrypt(Session::get('hsp_user_data')['profile_picture']);

        $rules = [
            'profile_picture' => ($old_profile_picture) ? 'nullable' : 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'sr_code' => 'required_if:position,==,student,teacher',
            'grade_level' => 'required_if:position,==,student',
            'department' => 'required_if:position,==,student,teacher',
            'birthdate' => 'required',
            'sex' => ['required', 'in:female,male'],
            'civil_status' => ['required', 'in:single,married,separated,widowed'],
            'religion' => 'required',
            'contact_number' => 'required',
            'position' => ['required', 'in:student,teacher,school personnel'],
            'province' => 'required',
            'city' => 'required',
            'barangay' => 'required',
        ];

        // required if student is in college
        if($request->position=='student' && str_contains($request->grade_level, 'college')){
            $rules['program'] = 'required';
        }

        $messages = [
            'sr_code.required_if' => 'The sr code field is required.',
            'grade_level.required_if' => 'The grade level field is required.',
            'department.required_if' => 'The department field is required.',
            'program.required_if' => 'The program level field is required.',
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

                // add new address if empty new acc
                if(!$acc->add_id){
                    $add = new Address;
                    $add->prov_id = $request->province;
                    $add->mun_id = $request->city;
                    $add->brgy_id = $request->barangay;
                    $add->save();
                    $acc->add_id = $add->getKey();
                }   
                else{
                    $add = Address::where('add_id', $acc->add_id)->first();
                    $add->prov_id = $request->province;
                    $add->mun_id = $request->city;
                    $add->brgy_id = $request->barangay;
                    $add->save();
                }

                if($request->profile_picture){
                    $path = '/public/photos/';
                    $file = $request->file('profile_picture');
                    $file_name = $acc->acc_id.'_'.time().'.'.$file->extension();
                    $upload = $file->storeAs($path, $file_name);

                    if($acc->pi_photo){
                        Storage::delete($path.$acc->pi_photo); 
                    }

                    $acc->pi_photo = $file_name;
                }
                   
                $acc->pi_firstname = $request->first_name;
                $acc->pi_middlename = $request->middle_name;
                $acc->pi_lastname = $request->last_name;
                $acc->pi_srcode = $request->sr_code;
                $acc->pi_birthdate = $request->birthdate;
                $acc->pi_sex = $request->sex;
                $acc->pi_civil_status = $request->civil_status;
                $acc->pi_grade_level = ($request->position=='student') ? $request->grade_level : null;
                $acc->dept_id = ($request->position!='school personnel') ? $request->department : null;
                $acc->prog_id = ($request->position=='student') ? $request->program : null;
                $acc->pi_contact_no = $request->contact_number;
                $acc->rlgn_id = $request->religion;
                $acc->pi_position = $request->position;
                $acc->save();

                // Updating session data
                $acc_data = Session::get('hsp_user_data');
                $acc_data['first_name'] = Crypt::encrypt($request->first_name);
                $acc_data['middle_name'] = Crypt::encrypt($request->middle_name);
                $acc_data['last_name'] = Crypt::encrypt($request->last_name);
                $acc_data['position'] = Crypt::encrypt($request->position);
                $acc_data['profile_picture'] = Crypt::encrypt($acc->pi_photo);
                Session::put('hsp_user_data', $acc_data);

                $response = [
                    'title' => 'Success!',
                    'message' => 'Personal Information Updated.',
                    'icon' => 'success',
                    'status' => 200,
                    'profile_picture_src' => asset('storage/photos/'.$acc->pi_photo),
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

    public function send_verification_link(Request $request){

        if($request->has('gsuite_email')){
            $rules = [
                'gsuite_email' => ['required', 'email', new GsuiteRule, 'unique:personal_information,pi_gsuite_email']
            ];
        }

        if($request->has('personal_email')){
            $rules = [
                'personal_email' => ['required', 'email', new NotGsuiteRule, 'unique:personal_information,pi_personal_email']
            ];
        }

        if(!$request->has('personal_email') && !$request->has('gsuite_email')){
            $rules = [
                'personal_email' => ['required'],
                'gsuite_email' => ['required']
            ];
        }

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            $response = [
                'title' => 'Failed!',
                'message' => 'Invalid inputs',
                'icon' => 'error',
                'status' => 400,
                'errors' => $validator->messages(),
            ];
        }
        else{
            $acc_id = Crypt::decrypt(Session::get('hsp_user_data')['acc_id']);
            $email = ($request->has('gsuite_email')) ? $request->gsuite_email : $request->personal_email;

            $acc = Accounts::where('acc_id', $acc_id)->first();

            if($acc->acc_token_expr < date('Y-m-d')){
                $acc->acc_token = Hash::make($request->email);   
            } 
            $acc->acc_token_expr = Carbon::now()->addMinutes(15);
            $acc->save();

            $AuthFunction = new AuthFunction();
            $AuthFunction->send_email_token($email, 'register', $acc_id);

            $response = [
                'title' => 'Success!',
                'message' => 'Verification link is sent to your email!',
                'icon' => 'success',
                'status' => 200
            ];
        }

        echo json_encode($response);
    }
}
