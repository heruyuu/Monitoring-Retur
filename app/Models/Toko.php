<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;

    protected $table = 'tokos';
    protected $fillable = [
        'kd_toko','nm_toko','alamat'
    ];
    protected $guarded = [];
}
