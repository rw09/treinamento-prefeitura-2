<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contribuinte extends Model
{
    use HasFactory;

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
        return $this->hasMany(Contribuinte::class);
    }
}
