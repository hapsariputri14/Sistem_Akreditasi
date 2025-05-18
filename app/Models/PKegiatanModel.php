<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKegiatanModel extends Model
{
    use HasFactory;

    protected $table = 'p_kegiatan';
    protected $primaryKey = 'id_kegiatan';
    protected $fillable = [
        'id_dosen',
        'jenis_kegiatan',
        'tempat',
        'waktu',
        'peran'
    ];

    protected $casts = [
        'waktu' => 'date'
    ];

    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen');
    }
}
