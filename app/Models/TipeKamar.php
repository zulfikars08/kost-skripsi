<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class TipeKamar extends Model
{
    use HasFactory;

    protected $table = 'tipe_kamar';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'tipe_kamar',
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
        return $this->hasMany(Kamar::class, 'tipe_kamar_id');
    }

    public function lokasiKos()
    {
        return $this->belongsTo(LokasiKos::class, 'lokasi_id');
    }
}
