<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hinh extends Model
{
    protected $table="images";
    
    public function tintuc(){
    	return $this->belongsTo('App\TinTuc','idTinTuc','id');
    }

}
