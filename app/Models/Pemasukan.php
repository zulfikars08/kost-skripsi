<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Pemasukan extends Model
{
    use HasFactory;

    protected $table = 'pemasukan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
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
        'kode_pemasukan',
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

        static::creating(function ($model) {
            $model->id = Str::uuid(); // Automatically set UUID when creating a new record
        });

        // Generate kode_pengeluaran before saving a new Pengeluaran
        static::creating(function ($pemasukan) {
            $latestPemasukan = self::latest()->first();
            $latestNumber = $latestPemasukan ? (int)substr($latestPemasukan->kode_pemasukan, 3) : 0;
            $pemasukan->kode_pemasukan = 'PMK' . str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT);
        });
    }
}
