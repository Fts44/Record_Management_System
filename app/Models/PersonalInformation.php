<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $table = 'personal_information';
    protected $primaryKey = 'pi_id';

    // no need to use these columns as it has default value
    // 'pi_id'
    protected $fillable = [     
        'acc_id',
        'add_id',
        'pi_classification',
        'pi_position',
        'pi_firstname',
        'pi_middlename',
        'pi_lastname',
        'pi_suffixname',
        'pi_sex',
        'pi_birthdate',
        'pi_civil_status',
        'pi_religion',
        'pi_grade_level',
        'dept_id',
        'crs_id',
        'pi_year_level',
        'pi_gsuite_email',
        'pi_personal_email',
        'pi_contact_no',
        'pi_photo',
        'ttl_id',
        'pi_signature'
    ];

    public $timestamps = false;
}
