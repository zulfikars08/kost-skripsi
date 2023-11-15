<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    use HasFactory;

    protected $table = 'investor';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'nama_kos', 
        'jumlah_pintu',
        'lokasi_id',
        'laporan_id',
        'bulan',
        'tahun',
        'pendapatan_bersih'
    ];

    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'lokasi_id');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }
    public function laporanKeuangan()
    {
        return $this->belongsTo(LaporanKeuangan::class, 'laporan_id');
    }
}
