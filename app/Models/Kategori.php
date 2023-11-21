<?php

namespace App;

use App\Models\LokasiKos;
use App\Models\Penyewa;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Kategori extends Model
{
    protected $table = 'kategori';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'transaksi_id',
        'lokasi_id',
        'penyewa_id',
        'kategori',
        'jumlah',
        'total_pendapatan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid(); // Automatically set UUID when creating a new record
        });
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
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
