<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Investor extends Model
{
    use HasFactory;

    protected $table = 'investor';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid(); // Automatically set UUID when creating a new record
        });
    }
    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'lokasi_id');
    }
    public function tanggalInvestor()
    {
        return $this->belongsTo(TanggalInvestor::class, 'lokasi_id', 'lokasi_id')
            ->where('bulan', $this->bulan)
            ->where('tahun', $this->tahun);
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
