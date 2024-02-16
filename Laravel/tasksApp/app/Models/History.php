<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'name',
        'place',
        'description',
        'start_date',
        'due_date',
        'status',
    ];
}
