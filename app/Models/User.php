<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'phone',
        'roles',
        'address',
        'website',
        'dob',
        'objective',
        'interests',
        'is_active',
        'secret_key'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'roles', 'email_verified_at'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function education() {
        return $this->hasMany(Education::class,'user_id','id');
    }

    public function skills() {
        return $this->hasMany(Skill::class,'user_id','id');
    }

    public function experience() {
        return $this->hasMany(Experience::class,'user_id','id');
    }

    public function projects() {
        return $this->hasMany(ProjectAndPublication::class,'user_id','id');
    }

    public function extras() {
        return $this->hasMany(ExtraParam::class,'user_id','id');
    }
}
