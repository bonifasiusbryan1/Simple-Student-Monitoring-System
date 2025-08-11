<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    protected $table = 'skripsi';
    protected $primaryKey = 'nim';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'nim',
        'nilai',
        'status',
        'fileskripsi',
    ];
}
