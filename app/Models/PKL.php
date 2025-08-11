<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PKL extends Model
{
    protected $table = 'pkl';
    protected $primaryKey = 'nim';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'nim',
        'status',
        'nilai',
        'status_pkl',
        'filepkl',
    ];
}
