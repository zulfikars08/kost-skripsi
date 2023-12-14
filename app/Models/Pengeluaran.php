<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'kamar_id',
        'lokasi_id',
        'transaksi_id',
        'keterangan',
        'bulan',
        'tahun',
        'tanggal',
        'nama_kos',
        'tipe_pembayaran',
        'bukti_pembayaran',
        'tanggal_pembayaran_awal',
        'tanggal_pembayaran_akhir',
        'kode_pengeluaran',
        'status_pembayaran',
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
    public function laporanKeuangan()
{
    return $this->hasOne(LaporanKeuangan::class, 'pengeluaran_id');
}
    // Automatically generate kode_pengeluaran before saving
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid(); // Automatically set UUID when creating a new record
        });

        // Generate kode_pengeluaran before saving a new Pengeluaran
        static::creating(function ($pengeluaran) {
            $latestPengeluaran = self::latest()->first();
            $latestNumber = $latestPengeluaran ? (int)substr($latestPengeluaran->kode_pengeluaran, 3) : 0;
            $pengeluaran->kode_pengeluaran = 'PLR' . str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT);
        });

        static::deleting(function ($pengeluaran) {
            $pengeluaran->laporanKeuangan()->delete();
        });
    }
}

