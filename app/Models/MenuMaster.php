<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Website;

class MenuMaster extends Model
{
    protected $table = 'menu_master';
    protected $primaryKey = 'id';
    protected $fillable = ['website_id','title','link','active',];
    public $timestamps = true;
    
    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }

}
