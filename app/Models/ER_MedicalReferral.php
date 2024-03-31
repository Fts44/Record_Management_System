<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ER_MedicalReferral extends Model
{
    use HasFactory;

    protected $table = 'medical_referral';
    protected $primaryKey = 'mr_id';

    protected $fillable = [
        'mr_id',
        'mr_date',
        'mr_patient_name',
        'mr_age',
        'mr_sex',
        'dept_id',
        'prog_id',
        'mr_to',
        'mr_evaluation_type',
    ];

    public $timestamps = false;
}
