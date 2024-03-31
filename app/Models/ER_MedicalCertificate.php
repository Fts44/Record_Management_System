<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ER_MedicalCertificate extends Model
{
    use HasFactory;

    protected $table = 'medical_certificate';
    protected $primaryKey = 'mc_id';

    protected $fillable = [
        'mc_id',
        'mc_date',
        'mc_patient_name',
        'mc_age',
        'mc_sex',
        'mc_civil_status',
        'mc_date_examined',
        'mc_address',
        'mc_diagnosis',
        'mc_remarks',
        'mc_purpose'
    ];

    public $timestamps = false;
}
