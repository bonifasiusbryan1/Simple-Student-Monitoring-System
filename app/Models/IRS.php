<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IRS extends Model
{
    protected $table = 'irs';
    protected $primaryKey = ['nim', 'semester'];
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'semester',
        'jumlahsks',
        'nim',
        'status',
        'fileirs',
    ];
}
