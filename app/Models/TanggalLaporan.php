<?php

// app/Models/TanggalLaporan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class TanggalLaporan extends Model
{
    protected $table = 'tanggal_laporan';

    protected $fillable = ['lokasi_id', 'tahun', 'bulan', 'tanggal','nama_kos'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
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

    public function laporanKeuangan()
{
    return $this->hasMany(LaporanKeuangan::class, 'lokasi_id', 'lokasi_id')
        ->whereYear('tanggal', $this->tahun)
        ->whereMonth('tanggal', $this->bulan);
}

// LaporanKeuangan.php

}
