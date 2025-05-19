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
        'melibatkan_mahasiswa_s2',
        'status',
        'sumber_data',
        'bukti'
    ];

    protected $casts = [
        'status' => 'string',
        'sumber_data' => 'string'
    ];

    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen');
    }

    // Scope for filtering by data source
    public function scopeP3m($query)
    {
        return $query->where('sumber_data', 'p3m');
    }

    public function scopeDosen($query)
    {
        return $query->where('sumber_data', 'dosen');
    }
}
