<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_name',
        'company_name',
        'app_logo',
        'app_authorization',
        'app_mobile_name'
    ];
}
