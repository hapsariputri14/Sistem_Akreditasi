<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPengabdianModel extends Model
{
    use HasFactory;

    protected $table = 'p_pengabdian';
    protected $primaryKey = 'id_pengabdian';
    protected $fillable = [
        'id_dosen',
        'judul_pengabdian',
        'skema',
        'tahun',
        'dana',
        'peran',
        'melibatkan_mahasiswa_s2'
    ];

    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen');
    }
}
