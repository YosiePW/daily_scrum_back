<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Daily_scrum extends Model
{
    protected $table="daily_scrums";

    // public function users(){
        // disini kita katakan bahwa setiap user akan memiliki banyak post
        // keterangan: itu PostModel sesuaikan dengan nama MODEL POST yang agan gunakan
    // 	return $this->belongsTo('App\User', 'id_users');
    // }
}
