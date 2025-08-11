<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    //

    protected $fillable = [
        'user_id',
        'scholarship_id',
        'status',
        'remarks',
    ];

    // scholarhip relation
    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id');
    }

    // student relation
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // documents relation
    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class, 'application_id');
    }


}
