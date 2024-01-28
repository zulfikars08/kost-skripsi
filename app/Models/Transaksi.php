<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaksi extends Model
{
    protected $table = 'transaksi'; // Specify the table name if it's different from the model name
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
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

    public function updatePemasukan($data)
    {
        // Assuming you have a one-to-one relationship set up in your Transaksi model
        $pemasukan = $this->pemasukan()->first();
        if ($pemasukan) {
            $pemasukan->update($data);
        } else {
            $pemasukan = $this->pemasukan()->create($data);
        }
        return $pemasukan;
    }

    public function updateLaporanKeuangan($data)
    {
        $laporanKeuangan = LaporanKeuangan::updateOrCreate(
            [
                'transaksi_id' => $this->id,
                'pemasukan_id' => $data['pemasukan_id'] // Ensure this is set and unique for each pemasukan
            ],
            $data
        );
        return $laporanKeuangan;
    }

    public function updateTanggalLaporan($attributes)
    {
        $existingLaporan = TanggalLaporan::where('nama_kos', $attributes['nama_kos'])
                             ->where('bulan', $attributes['bulan'])
                             ->where('tahun', $attributes['tahun'])
                             ->first();

        if ($existingLaporan) {
            $existingLaporan->update($attributes);
        } else {
            TanggalLaporan::create($attributes);
        }
    }

    public function updateTanggalInvestor($attributes)
    {
        $existingInvestor = TanggalInvestor::where('nama_kos', $attributes['nama_kos'])
                               ->where('bulan', $attributes['bulan'])
                               ->where('tahun', $attributes['tahun'])
                               ->first();

        if ($existingInvestor) {
            $existingInvestor->update($attributes);
        } else {
            TanggalInvestor::create($attributes);
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid(); // Automatically set UUID when creating a new record
        });
    }
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

    public function pemasukan()
{
    return $this->hasOne(Pemasukan::class);
}

public function laporanKeuangan()
{
    return $this->hasOne(LaporanKeuangan::class);
}


}
