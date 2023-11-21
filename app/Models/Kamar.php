<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'lokasi_id',
        'no_kamar',
        'investor_id',
        'harga',
        'tipe_kamar',
        'fasilitas',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid(); // Automatically set UUID when creating a new record
        });
    }

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
    public function tipeKamar()
    {
        return $this->hasOne(TipeKamar::class, 'kamar_id');
    }
}
