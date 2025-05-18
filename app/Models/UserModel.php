<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserModel extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'jabatan',
        'no_telp',
        'alamat',
        'id_level'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function level()
    {
        return $this->belongsTo(LevelModel::class, 'id_level');
    }

    public function dokumenKriteria()
    {
        return $this->hasMany(DokumenKriteriaModel::class, 'id_user');
    }

    public function validatedDokumen()
    {
        return $this->hasMany(DokumenKriteriaModel::class, 'id_validator');
    }
}
