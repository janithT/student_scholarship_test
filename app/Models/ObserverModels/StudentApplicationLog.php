<?php

namespace App\Models\ObserverModels;

use Illuminate\Database\Eloquent\Model;

class StudentApplicationLog extends Model
{
    //
    protected $fillable = [
        'application_id',
        'user_id',
        'scholarship_id',
        'action',
        'changes',
    ];
}
