<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggalInvestor extends Model
{
    use HasFactory;
    protected $table = 'tanggal_investor';

    protected $fillable = ['jumlah_investor', 'lokasi_id', 'nama_kos', 'bulan', 'tahun'];

    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'lokasi_id');
    }

    public function investor()
{
    return $this->hasMany(Investor::class, 'lokasi_id', 'lokasi_id')
        ->whereYear('bulan', $this->bulan)
        ->whereMonth('tahun', $this->tahun);
}

}
