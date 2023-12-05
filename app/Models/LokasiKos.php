<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class LokasiKos extends Model
{
    use HasFactory;

    protected $table = 'lokasi_kos';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nama_kos',
        'jumlah_kamar',
        'alamat_kos'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid(); // Automatically set UUID when creating a new record
        });
    }
    

    public function kamars()
    {
        return $this->hasMany(Kamar::class, 'lokasi_id');
    }

    public function penyewa()
    {
        return $this->hasManyThrough(Penyewa::class, Kamar::class, 'lokasi_id', 'kamar_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'lokasi_id');
    }
    // LokasiKos.php (LokasiKos model)
// public function totalJumlahPintu($namaKos)
// {
//     return $this->investors()
//         ->where('nama_kos', $namaKos)
//         ->sum('jumlah_pintu');
// }
public function investors()
{
    return $this->hasMany(Investor::class, 'lokasi_id', 'id');
}
}
