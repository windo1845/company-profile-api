<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Website;

class MenuSub extends Model
{
    protected $table = 'menu_sub';
    protected $primaryKey = 'id';
    protected $fillable = ['menu_master_id','website_id','title','link','active',];
    public $timestamps = true;
    
    public function menuMaster()
    {
        return $this->belongsTo(MenuMaster::class, 'menu_master_id');
    }
    
    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }
    

}
