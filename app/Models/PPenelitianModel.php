<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPenelitianModel extends Model
{
    use HasFactory;

    protected $table = 'p_penelitian';
    protected $primaryKey = 'id_penelitian';
    protected $fillable = [
        'id_dosen',
        'judul_penelitian',
        'skema',
        'tahun',
        'dana',
        'peran',
        'melibatkan_mahasiswa_s2',
        'bukti'
    ];

    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen');
    }
}
