<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'username';
    public $timestamps = false;
    public $incrementing = false;
    /** The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'role'
    ];
    
    /** The attributes that should be hidden for serialization.
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'nim', 'username');
    }

    public function dosenwali()
    {
        return $this->hasOne(DosenWali::class, 'nip', 'username');
    }

    public function departemen()
    {
        return $this->hasOne(Departemen::class, 'nip', 'username');
    }

    public function operator()
    {
        return $this->hasOne(Operator::class, 'nip', 'username');
    }

    public function irs()
    {
        return $this->hasMany(IRS::class, 'nim', 'username');
    }

    public function khs()
    {
        return $this->hasMany(KHS::class, 'nim', 'username');
    }

    public function pkl()
    {
        return $this->hasOne(PKL::class, 'nim', 'username');
    }

    public function skripsi()
    {
        return $this->hasOne(Skripsi::class, 'nim', 'username');
    }

}