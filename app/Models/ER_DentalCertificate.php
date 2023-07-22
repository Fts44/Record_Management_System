<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ER_DentalCertificate extends Model
{
    use HasFactory;

    protected $table = 'dental_certificate';
    protected $primaryKey = 'dc_id';

    protected $fillable = [
            'dc_date',
            'dc_patient_name',
            'dc_age',
            'dc_sex',
            'dc_civil_status',
            'dc_address',
            'dc_diagnosis_treatment',
            'dc_remarks'
    ];

    public $timestamps = false;
}
