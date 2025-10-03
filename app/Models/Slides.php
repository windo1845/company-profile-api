<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Website;

class Slides extends Model
{
    protected $table = 'slides';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','website_id','title','image','updated_by',];
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
