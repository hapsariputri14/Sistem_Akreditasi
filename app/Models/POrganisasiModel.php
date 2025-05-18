<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POrganisasiModel extends Model
{
    use HasFactory;

    protected $table = 'p_organisasi';
    protected $primaryKey = 'id_organisasi';
    protected $fillable = [
        'id_dosen',
        'nama_organisasi',
        'kurun_waktu',
        'tingkat'
    ];

    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen');
    }
}
