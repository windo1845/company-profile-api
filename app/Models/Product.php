<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Website;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','website_id','nama_produk','product_name','keterangan_produk','product_description','image','ukuran_produk_kg','ukuran_produk_kg_pcs','ukuran_produk_g','ukuran_produk_g_pcs','tanggal','active','updated_by',];
    public $timestamps = true;
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }

}
