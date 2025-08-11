<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KHS extends Model
{
    protected $table = 'khs';
    protected $primaryKey = ['nim', 'semester'];
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'nim',
        'semester',
        'skss',
        'sksk',
        'ips',
        'ipk',
        'status',
        'filekhs',
    ];
}
