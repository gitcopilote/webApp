<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Task extends Model
{
    use HasFactory;


    private $color = [

        'nouveau' => 'bg-green-200',
        'assigner' => 'bg-yellow-200',
        'désassigneer' => 'bg-yellow-500',
        'En cours' => 'bg-blue-500',
        'Terminer' => 'bg-green-500',
        'non traiter' => 'bg-green-500',
        'partiellement résolue' => 'bg-green-500',
        'problème persistant' => 'bg-green-500',
        'transmis' => 'bg-green-500',
        'prise en charge' => 'bg-green-500',
        'totalement résolue' => 'bg-green-500',

    ];


    protected $fillable = ['name', 'place', 'start_date', 'due_date', 'description', 'user_created_by', 'user_assigned_to'];



    public function statusColor(): string
    {
        return $this->color[$this->status];
    }




    public function user()
    {
        return $this->belongsTo(User::class, 'user_assigned_to');
    }


    public function users()
    {
        return $this->belongsTo(User::class, 'user_created_by');
    }






    // public function isActive()
    // {
    //     $now = Carbon::now();

    //     $start_date = Carbon::parse($this->start_date);
    //     $due_date = Carbon::parse($this->due_date);

    //     // return $start_date->isAfter($now) && $start_date->isBefore($due_date) &&
    //     //     !in_array($this->status, ['En cours', 'Terminer']);


    //     return $start_date->isSameDay($now) || $start_date->isAfter($now) &&
    //         $start_date->isBefore($due_date) &&
    //         !in_array($this->status, ['En cours', 'totalement résolue']);
    // }


    public function isActive()
    {
        $now = Carbon::now();

        $start_date = Carbon::parse($this->start_date);
        $due_date = !empty($this->due_date) ? Carbon::parse($this->due_date) : null;

        // Si la date d'échéance est vide, continuer la logique sans la considérer
        if (empty($this->due_date)) {
            return $start_date->isSameDay($now) || $start_date->isAfter($now) &&
                !in_array($this->status, ['En cours', 'totalement résolue']);
        }

        // Sinon, poursuivre la logique en considérant la date d'échéance
        return $start_date->isSameDay($now) || $start_date->isAfter($now) &&
            $start_date->isBefore($due_date) &&
            !in_array($this->status, ['En cours', 'totalement résolue']);
    }
}
