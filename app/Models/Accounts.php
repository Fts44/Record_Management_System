<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $table = 'accounts';
    protected $primaryKey = 'acc_id';

    // no need to use these columns as it has default value
    // acc_id
    protected $fillable = [
        'acc_is_verified', 
        'acc_email_verified', 
        'acc_password', 
        'acc_created_date',
        'acc_token', 
        'acc_toke_last_send',
        'acc_token_expr', 
        'acc_type',
        'acc_last_login', 
        'acc_info_last_update'
    ];

    public $timestamps = false;
}
