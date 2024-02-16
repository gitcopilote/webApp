<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class breakdown extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        // Autres champs si nécessaire
    ];
}
