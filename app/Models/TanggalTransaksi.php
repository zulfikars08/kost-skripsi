<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanggalTransaksi extends Model
{
    protected $table = 'tanggal_transaksi'; // Specify the table name if it's different from the model name
    protected $fillable = [
        'transaksi_id',
        'bulan',
        'tahun',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'transaksi_id'); // Use the correct foreign key
    }
}

