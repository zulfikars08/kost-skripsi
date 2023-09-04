<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    use HasFactory;

    protected $table = 'penyewa';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'no_hp',
        'pekerjaan',
        'perusahaan',
        'tanggal_lahir',
        'status'
    ];
}
