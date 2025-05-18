<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKaryaBukuModel extends Model
{
    use HasFactory;

    protected $table = 'p_karya_buku';
    protected $primaryKey = 'id_karya_buku';
    protected $fillable = [
        'id_dosen',
        'judul_buku',
        'tahun',
        'jumlah_halaman',
        'penerbit',
        'isbn'
    ];

    public function dosen()
    {
        return $this->belongsTo(DosenModel::class, 'id_dosen');
    }
}
