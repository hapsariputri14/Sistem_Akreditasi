<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPrestasiModel extends Model
{
    use HasFactory;

    protected $table = 'p_prestasi';
    protected $primaryKey = 'id_prestasi';
    protected $fillable = [
        'id_dosen',
        'prestasi_yang_dicapai',
        'waktu_pencapaian',
        'tingkat'
    ];

    protected $casts = [
        'waktu_pencapaian' => 'date'
    ];

    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen');
    }
}
