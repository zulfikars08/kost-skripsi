<?php

// app/Models/Kamar.php

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

    protected $with = ['fasilitas'];
    protected $fillable = [
        'lokasi_id',
        'no_kamar',
        'investor_id',
        'tipe_kamar_id',
        'harga',
        'tipe_kamar',
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

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class);
    }

    public function penyewa()
    {
        return $this->hasMany(Penyewa::class, 'kamar_id');
    }

    public function investor()
    {
        return $this->belongsTo(Investor::class, 'investor_id');
    }

   // In Kamar.php

   public function tipeKamar()
{
    return $this->belongsTo(TipeKamar::class, 'tipe_kamar_id'); // Change 'tipe_kamar' to 'tipe_kamar_id'
}


}
