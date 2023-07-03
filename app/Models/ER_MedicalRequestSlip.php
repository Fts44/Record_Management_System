<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ER_MedicalRequestSlip extends Model
{
    use HasFactory;

    protected $table = 'medical_request_slip';
    protected $primaryKey = 'mrs_id';

    protected $fillable = [
        'mrs_patient_name', 
        'mrs_date', 
        'mrs_age',
        'mrs_sex', 
        'mrs_requested_by',
        'mrs_chest_xray',
        'mrs_cbc',
        'mrs_urinalysis',
        'mrs_fecalysis',
        'mrs_drug_test',
        'mrs_blood_typing',
        'mrs_others',
    ];

    public $timestamps = false;
}
