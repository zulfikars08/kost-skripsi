<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';

    protected $fillable = [
        'kamar_id',
        'lokasi_id',
        'transaksi_id',
        'keterangan',
        'tipe_pembayaran',
        'bukti_pembayaran',
        'bulan',
        'tahun',
        'tanggal',
        'nama_kos',
        'kode_pengeluaran',
        'kategori',
        'jumlah',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'lokasi_id', 'id');
    }
    
    // Automatically generate kode_pengeluaran before saving
    public static function boot()
    {
        parent::boot();

        // Generate kode_pengeluaran before saving a new Pengeluaran
        static::creating(function ($pengeluaran) {
            $latestPengeluaran = self::latest()->first();
            $latestNumber = $latestPengeluaran ? (int)substr($latestPengeluaran->kode_pengeluaran, 3) : 0;
            $pengeluaran->kode_pengeluaran = 'PMK' . str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT);
        });
    }
}
