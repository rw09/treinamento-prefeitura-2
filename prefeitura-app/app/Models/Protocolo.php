<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Protocolo extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
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
        return $this->belongsTo(Contribuinte::class, 'contribuinte_id');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function acompanhamentos(): HasMany
    {
        return $this->hasMany(Acompanhamento::class);
    }

    public function anexos(): HasMany
    {
        return $this->hasMany(Anexo::class);
    }

}
