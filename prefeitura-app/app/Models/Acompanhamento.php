<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acompanhamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'observacao',
        'protocolo_id',
        'user_id',
    ];


    public function protocolo()
    {
        return $this->belongsTo(Protocolo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
