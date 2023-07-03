<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $table = 'document_type';
    protected $primaryKey = 'dt_id';

    protected $fillable = [
        'dt_table_name',
    ];

    public $timestamps = false;
}
