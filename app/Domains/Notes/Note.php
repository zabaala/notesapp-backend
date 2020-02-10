<?php

namespace App\Domains\Notes;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $dates = [
        'created_at', 'updated_at'
    ];
}
