<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ER_ExcuseSlip extends Model
{
    use HasFactory;

    protected $table = 'excuse_slip';
    protected $primaryKey = 'es_id';

    protected $fillable = [
        'es_id', 
        'es_date',
        'es_patient_name',
        'es_age',
        'dept_id',
        'prog_id',
        'es_authorized_by',
        'es_complaints',
        'es_diagnosis'
    ];

    public $timestamps = false;
}
