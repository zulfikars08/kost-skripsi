<?php

namespace App\Models;

use App\Kategori;
use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    protected $table = 'laporan_keuangan';

    protected $fillable = [
        'lokasi_id',
        'kamar_id',
        'transaksi_id',
        'penyewa_id',
        'kategori_id',
        'bulan',
        'tahun',
        'pemasukan',
        'pengeluaran',
        'pendapatan_bersih',
        'nama_kos',
        'tanggal',
        'kode_laporan',
        'jenis',
        'keterangan',
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(LokasiKos::class, 'lokasi_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }


    // Define other relationships if needed, such as transaksi and penyewa

    // Define other properties and methods as necessary
}
