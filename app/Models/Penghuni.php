<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Penghuni extends Model
{
    use HasFactory;

    protected $table = 'penghuni';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_hp',
        'pekerjaan',
        'penyewa_id',
        'perusahaan',
        'martial_status',
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid(); // Automatically set UUID when creating a new record
        });
    }
    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'penyewa_id'); 
    }
    
   
}
