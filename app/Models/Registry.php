<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registry extends Model
{
    protected $fillable = [
        'cpf',
        'cpf_invalid',
        'private',
        'incomplete',
        'last_buy',
        'mid_ticket',
        'last_ticket',
        'usual_store',
        'usual_store_invalid',
        'last_store',
        'last_store_invalid'
    ];
}
