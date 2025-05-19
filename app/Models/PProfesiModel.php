<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PProfesiModel extends Model
{
    use HasFactory;

    protected $table = 'p_profesi';
    protected $primaryKey = 'id_profesi';
    protected $fillable = [
        'id_dosen',
        'perguruan_tinggi',
        'kurun_waktu',
        'gelar',
        'bukti'
    ];

    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen');
    }
}
