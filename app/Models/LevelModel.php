<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'level';
    protected $primaryKey = 'id_level';
    protected $fillable = ['nama_level', 'kode_level'];

    public function users()
    {
        return $this->hasMany(UserModel::class, 'id_level');
    }
}
