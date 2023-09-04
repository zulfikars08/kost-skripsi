<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenants extends Model
{
    use HasFactory;

    protected $table = 'tenants';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'gender',
        'status',
        'job',
        'address'
    ];
}
