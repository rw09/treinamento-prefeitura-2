<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anexo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'extensao',
        'caminho',
        'protocolo_id',
    ];

    public function protocolo() :BelongsTo
    {
        return $this->belongsTo(Protocolo::class);
    }
}
