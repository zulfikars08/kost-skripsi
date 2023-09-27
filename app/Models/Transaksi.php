<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi'; // Specify the table name

    protected $fillable = [
        'kamar_id',
        'penghuni_id',
        'lokasi_id',
        'penyewa_id',
        'tipe_pembayaran',
        'jumlah_tarif',
        'bukti_pembayaran',
        'tanggal_pembayaran_awal',
        'tanggal_pembayaran_akhir',
        'status_pembayaran',
        'kebersihan',
        'pengeluaran',
        'keterangan',
    ];

    // Define the relationships with other models
    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'penghuni_id');
    }

    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'lokasi_id');
    }

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'penyewa_id');
    }
}
