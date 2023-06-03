<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';
    protected $primaryKey = 'add_id';

    protected $fillable = [
        'add_id', 
        'brgy_id',
        'mun_id',
        'prov_id'
    ];

    public $timestamps = false;
}
