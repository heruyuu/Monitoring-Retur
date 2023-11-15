<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faktur extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'fakturs';
    protected $fillable = [
        'kd_toko','no_faktur','tgl_faktur','tgl_tiba','pejabat','no_plat_mu','user_id','status','created_at'
    ];
    // protected $guarded = [];

    public function item_retur()
    {
        return $this->hasMany(ItemRetur::class, 'faktur_id','id');
    }
}
