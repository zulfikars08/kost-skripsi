<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TanggalTransaksi extends Model
{
    protected $table = 'tanggal_transaksi'; // Specify the table name if it's different from the model name 
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'transaksi_id',
        'bulan',
        'tahun',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid(); // Automatically set UUID when creating a new record
        });
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'tanggal_transaksi_id'); // Ensure the foreign key is correct
    }
}
