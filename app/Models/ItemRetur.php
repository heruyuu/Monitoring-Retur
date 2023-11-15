<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRetur extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'item_returs';
    protected $fillable = [
        'kd_toko','faktur_id','produk_id','qty','bta','sb','bl','bk','bnf','brp','keterangan','status','catatan'
    ];
    protected $guarded = [];
}
