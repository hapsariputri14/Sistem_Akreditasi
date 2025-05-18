<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPublikasiModel extends Model
{
    use HasFactory;

    protected $table = 'p_publikasi';
    protected $primaryKey = 'id_publikasi';
    protected $fillable = [
        'id_dosen',
        'judul',
        'tempat_publikasi',
        'tahun_publikasi',
        'jenis_publikasi',
        'dana',
        'melibatkan_mahasiswa_s2'
    ];

    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen');
    }
}
