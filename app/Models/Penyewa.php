<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penyewa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'penyewa'; // Name of the table in the database
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id'; // Primary key field name
    public $incrementing = true; // Set to true if your primary key is auto-incrementing

    // Fillable fields in the database
    protected $fillable = [
        'nama',
        'no_kamar',
        'kamar_id',
        'penghuni_id',
        'lokasi_id',
        'tipe_pembayaran',
        'jumlah_tarif',
        'bukti_pembayaran',
        'tanggal_pembayaran_awal',
        'tanggal_pembayaran_akhir',
        'keterangan',
        'status_pembayaran',
        'status_penyewa',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    
    // Define relationships if needed
  // Penyewa.php
    public function kamar()
    {
      return $this->belongsTo(Kamar::class, 'kamar_id');
    }
    public function penghuni()
    {
        return $this->belongsTo(Penghuni::class, 'penghuni_id');
    }

    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'lokasi_id');
    }
}
