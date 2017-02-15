<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function user() {
    	return $this->belongsTo('App\User');
    }

    protected $fillable = ['title', 'user_id', 'info', 'event_date', 'time', 'location'];
}
