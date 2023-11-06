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
        'penyewa_id',
        'perusahaan',
        'martial_status',
    ];
    

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'penyewa_id'); 
    }
    
   
}
