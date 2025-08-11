<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $table = 'departemen';
    protected $primaryKey = 'nip';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'alamat',
        'provinsi',
        'notelp',
        'foto',
    ];
}
