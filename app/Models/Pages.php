<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Website;

class Pages extends Model
{
    protected $table = 'pages';
    protected $primaryKey = 'id';
    protected $fillable = ['website_id','menu_master_id','menu_sub_id','link','title','content','title_en','content_en','active',];
    public $timestamps = true;

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }

    public function menuMaster()
    {
        return $this->belongsTo(MenuMaster::class, 'menu_master_id');
    }

    public function menuSub()
    {
        return $this->belongsTo(MenuSub::class, 'menu_sub_id');
    }

}
