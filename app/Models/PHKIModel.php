<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PHKIModel extends Model
{
    use HasFactory;

    protected $table = 'p_hki';
    protected $primaryKey = 'id_hki';
    protected $fillable = [
        'id_dosen',
        'judul',
        'tahun',
        'skema',
        'nomor',
        'melibatkan_mahasiswa_s2'
    ];

    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen');
    }
}
