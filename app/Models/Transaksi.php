<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi'; // Specify the table name if it's different from the model name
    protected $fillable = [
        // 'nama_kos',
        'tanggal',
        'jumlah_tarif',
        // 'kebersihan',
        // 'pengeluaran',
        'tipe_pembayaran',
        'bukti_pembayaran',
        'tanggal_pembayaran_awal',
        'tanggal_pembayaran_akhir',
        'keterangan',
        'status_pembayaran',
        'kamar_id',
        'lokasi_id',
        'penyewa_id',
        'tanggal_transaksi_id'
    ];

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'penyewa_id');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'lokasi_id');
    }

    public function tanggalTransaksi()
    {
        return $this->belongsTo(TanggalTransaksi::class);
    }
}

