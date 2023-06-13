<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $table = 'emergency_contact';
    protected $primaryKey = 'ec_id';

    protected $fillable = [
        'ec_firstname', 
        'ec_middlename', 
        'ec_lastname', 
        'ec_contact_no',
        'ec_telephone_no', 
        'ec_relationship',
        'add_id'
    ];

    public $timestamps = false;
}
