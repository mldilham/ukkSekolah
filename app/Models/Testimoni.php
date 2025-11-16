<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $table = 'testimoni';

    protected $fillable = [
        'nama',
        'jabatan',
        'isi_testimoni',
        'foto',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
