<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scholarship extends Model
{
    use SoftDeletes;
    
    public $fillable = [

        'title',
        'description',
        'status',
        'deadline'

    ];

    public function applications()
    {
        return $this->hasMany(Application::class, 'scholarship_id');
    }
}
