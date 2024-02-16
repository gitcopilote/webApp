<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Task;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // fonction indiquant qu'il y' une relation 'roles'  belongsTomany

    public function roles()
    {
        return $this->belongsToMany(role::class);
    }

    public function isAdmin()
    {
        return $this->roles()->where('name', '=', 'administrateur')->exists();
    }






    public function isStorekeeper()
    {
        return $this->roles()->where('name', '=', 'magasinier')->exists();
    }



    // public function isMain_maga(array $roles)
    // {
    //     return $this->roles()->whereIn('name',$roles)->exists();
    // }


    // public function isAdmin_main(array $roles)
    // {
    //     return $this->roles()->whereIn('name',$roles)->exists();
    // }




    public function isMaintainer()
    {
        return $this->roles()->where('name', '=', 'maintenancier')->exists();
    }




    public function createTask()
    {
        return $this->hasMany(Task::class, 'user_created_by');
    }


    public function assignedTask()
    {
        return $this->hasMany(Task::class, 'user_assigned_to');
    }


    public function created_task()
    {
        return $this->hasMany(Task::class, 'user_created_by');
    }


    public function assigned()
    {
        return $this->hasMany(Task::class, 'user_assigned_to');
    }


}
