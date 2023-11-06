<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Departamento extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    //protected $with = ['protocolos'];

    protected $fillable = [
        'nome'
    ];

    public function protocolos(): HasMany
    {
        return $this->hasMany(Protocolo::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
