<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Protocolo extends Model
{
    use HasFactory;

   // protected $with = ['contribuinte', 'departamento'];

    protected $fillable = [
        'descricao',
        'prazo',
        'situacao',
        'contribuinte_id',
        'departamento_id',
    ];

    public function contribuinte(): BelongsTo
    {
        return $this->belongsTo(Contribuinte::class);
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    public function acompanhamentos(): HasMany
    {
        return $this->hasMany(Acompanhamento::class);
    }

}
