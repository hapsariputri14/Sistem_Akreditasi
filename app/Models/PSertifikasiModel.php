<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PSertifikasiModel extends Model
{
    use HasFactory;

    protected $table = 'p_sertifikasi';
    protected $primaryKey = 'id_sertifikasi';
    protected $fillable = [
        'id_dosen',
        'tahun_diperoleh',
        'penerbit',
        'nama_sertifikasi',
        'nomor_sertifikat',
        'masa_berlaku'
    ];

    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen');
    }
}
