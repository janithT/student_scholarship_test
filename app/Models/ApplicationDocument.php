<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    //
    protected $fillable = [
        'application_id',
        'user_id',
        'mime_type',
        'file_name',
        'file_path',
        'file_size',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

}
