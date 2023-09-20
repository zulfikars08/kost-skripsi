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
        'harga',
        'keterangan',
        'fasilitas',
        'status'
    ];

    // Define the reverse relationship to LokasiKos
    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'lokasi_id'); // Assuming 'kost_id' is the foreign key column
    }
    public function kamar()
{
    return $this->belongsTo(Kamar::class);
}

 public function penyewa()
    {
        return $this->hasMany(Penyewa::class, 'kamar_id');
    }
}










