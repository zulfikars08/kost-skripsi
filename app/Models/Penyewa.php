<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    use HasFactory;

    protected $table = 'penyewa';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'nama',
        'tipe_pembayaran',
        'kamar_id',
        'penghuni_id',
        'jumlah_tarif',
        'tanggal_awal',
        'tanggal_akhir',
        'keterangan',
        'tanggal_lahir',
        'status_pembayaran'
    ];

    public function kamar()
{
    return $this->belongsTo(Kamar::class, 'kamar_id');
}

public function penghuni()
{
    return $this->belongsTo(Penghuni::class, 'penghuni_id');
}


}