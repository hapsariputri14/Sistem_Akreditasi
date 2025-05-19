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
        'tingkat',
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
