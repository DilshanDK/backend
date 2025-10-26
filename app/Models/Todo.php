<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Todo extends Model
{
    protected $collection = 'todos';

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
}
