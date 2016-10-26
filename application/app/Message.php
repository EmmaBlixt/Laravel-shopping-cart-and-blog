<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function user() {
    	return $this->belongsTo('App\User', 'to_id');
    }


    public function sender(){
    	return $this->belongsTo('App\User', 'from_id');
    }


    protected $fillable = ['message', 'from_id', 'to_id'];
}
