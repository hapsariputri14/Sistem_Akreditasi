<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenModel extends Model
{
    use HasFactory;

    protected $table = 'dosen';
    protected $primaryKey = 'id_dosen';
    protected $fillable = [
        'nama_lengkap',
        'tempat_tanggal_lahir',
        'nidn',
        'nip',
        'gelar_depan',
        'gelar_belakang',
        'pendidikan_terakhir',
        'pangkat',
        'jabatan_fungsional'
    ];

    // Relationships with all portfolio tables
    public function sertifikasi()
    {
        return $this->hasMany(PSertifikasiModel::class, 'id_dosen');
    }

    public function kegiatan()
    {
        return $this->hasMany(PKegiatanModel::class, 'id_dosen');
    }

    public function prestasi()
    {
        return $this->hasMany(PPrestasiModel::class, 'id_dosen');
    }

    public function organisasi()
    {
        return $this->hasMany(POrganisasiModel::class, 'id_dosen');
    }

    public function publikasi()
    {
        return $this->hasMany(PPublikasiModel::class, 'id_dosen');
    }

    public function penelitian()
    {
        return $this->hasMany(PPenelitianModel::class, 'id_dosen');
    }

    public function karyaBuku()
    {
        return $this->hasMany(PKaryaBukuModel::class, 'id_dosen');
    }

    public function hki()
    {
        return $this->hasMany(PHKIModel::class, 'id_dosen');
    }

    public function pengabdian()
    {
        return $this->hasMany(PPengabdianModel::class, 'id_dosen');
    }

    public function profesi()
    {
        return $this->hasMany(PProfesiModel::class, 'id_dosen');
    }
}
