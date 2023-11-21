<?php

namespace App\Models;

use App\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class LaporanKeuangan extends Model
{
    protected $table = 'laporan_keuangan';
    
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'lokasi_id',
        'kamar_id',
        'transaksi_id',
        'penyewa_id',
        'kategori_id',
        'pemasukan_id',
        'pengeluaran_id',
        'tipe_pembayaran',
        'bukti_pembayaran',
        'tanggal_pembayaran_awal',
        'tanggal_pembayaran_akhir',
        'status_pembayaran',
        'bulan',
        'tahun',
        'pemasukan',
        'kode_pengeluaran',
        'kode_pemasukan',
        'pengeluaran',
        'pendapatan_bersih',
        'nama_kos',
        'tanggal',
        'kode_laporan',
        'jenis',
        'keterangan',
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'lokasi_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function pemasukan()
    {
        return $this->belongsTo(Pemasukan::class, 'pemasukan_id');
    }

    public function pengeluaran()
    {
        return $this->belongsTo(Pengeluaran::class, 'pengeluaran_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid(); // Automatically set UUID when creating a new record
        });

        // Event listener for created event
        static::created(function ($model) {
            $model->updatePendapatanBersih();
        });

        // Event listener for updated event
        static::updated(function ($model) {
            $model->updatePendapatanBersih();
        });

        static::creating(function ($laporanKeuangan) {
            $latestLaporan = self::latest()->first();
            $latestNumber = $latestLaporan ? (int)substr($latestLaporan->kode_laporan, 3) : 0;
            $laporanKeuangan->kode_laporan = 'LPR' . str_pad($latestNumber + 1, 3, '0', STR_PAD_LEFT);
        });
    }

    public function updatePendapatanBersih()
    {
        $lokasiId = $this->lokasi_id;
        $bulan = $this->bulan;
        $tahun = $this->tahun;

        // Get all records for the given location, month, and year
        $laporanKeuanganRecords = LaporanKeuangan::where('lokasi_id', $lokasiId)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        // Calculate and update pendapatan bersih for each record
        $prevPendapatanBersih = 0;
        foreach ($laporanKeuanganRecords as $record) {
            $record->update(['pendapatan_bersih' => $prevPendapatanBersih + $record->pemasukan - $record->pengeluaran]);
            $prevPendapatanBersih = $record->pendapatan_bersih;
        }
    }

    // Define other relationships if needed, such as transaksi and penyewa

    // Define other properties and methods as necessary
}
