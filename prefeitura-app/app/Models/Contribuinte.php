<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Contribuinte extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    
    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf',
        'sexo',
        'cidade',
        'bairro',
        'rua',
        'numero',
        'complemento',
    ];

    public function protocolos(): HasMany
    {
        return $this->hasMany(Protocolo::class);
    }
}
