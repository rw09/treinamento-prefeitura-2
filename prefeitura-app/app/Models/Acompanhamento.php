<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Acompanhamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'observacao',
        'protocolo_id',
        'user_id',
    ];


    public function protocolo(): BelongsTo
    {
        return $this->belongsTo(Protocolo::class)->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
