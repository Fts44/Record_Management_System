<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectronicRecord extends Model
{
    use HasFactory;

    protected $table = 'electronic_record';
    protected $primaryKey = 'er_id';

    protected $fillable = [
        'er_created_date',
        'er_last_update',
        'er_org_id',
        'dt_id', 
        'physician_id',
        'patient_id',
    ];

    public $timestamps = false;
}
