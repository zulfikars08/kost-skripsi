<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Penyewa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'penyewa'; // Name of the table in the database
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Fillable fields in the database
    protected $fillable = [
        'kode_penyewa',
        'nama',
        'no_kamar',
        'nama_kos',
        'kamar_id',
        'lokasi_id',
        'status_penyewa',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    // Define relationships if needed
  // Penyewa.php
  protected static function boot()
  {
      parent::boot();

      static::creating(function ($model) {
          $model->id = Str::uuid(); // Automatically set UUID when creating a new record
      });
  }
  public function kamar()
  {
      return $this->belongsTo(Kamar::class, 'kamar_id');
  }

  public function lokasiKos()
  {
      return $this->belongsTo(LokasiKos::class, 'lokasi_id');
  }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
    public function penghuni()
{
    return $this->hasMany(Penghuni::class);
}

}
