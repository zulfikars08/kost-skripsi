<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'lokasi_id',
        'no_kamar',
        'investor_id',
        'nama_investor',
        'harga',
        'tipe_kamar',
        'fasilitas',
        'status'
    ];

    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'lokasi_id');
    }

    public function penyewa()
    {
        return $this->hasMany(Penyewa::class, 'kamar_id');
    }

    public function investor()
    {
        return $this->belongsTo(Investor::class, 'investor_id');
    }
}
