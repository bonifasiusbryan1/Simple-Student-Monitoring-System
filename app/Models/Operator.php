<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $table = 'operator';
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
