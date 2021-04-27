<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    const IN_PROGRESS = 0;
    const FINISHED = 1;

    protected $fillable = [
        'name',
        'status',
    ];
}
