<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    //protected $with = ['departamentos'];

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'password',
        'perfil',
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
        'cpf_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setPasswordAttribute($value) //encriptar a senha
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function departamentos(): BelongsToMany
    {
        return $this->belongsToMany(Departamento::class)->withTimestamps();
    }

    public function acompanhamentos(): HasMany
    {
        return $this->hasMany(Acompanhamento::class);
    }
    
}
