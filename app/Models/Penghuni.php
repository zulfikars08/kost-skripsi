<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghuni extends Model
{
    use HasFactory;

    protected $table = 'penghuni';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_hp',
        'pekerjaan',
        'perusahaan',
        'martial_status',
        'penyewa_id'
    ];

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'penyewa_id'); 
    }

    // public function penyewa()
    // {
    //     return $this->hasMany(Penyewa::class, 'penghuni_id');
    // }
}
