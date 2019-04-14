<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repo extends Model
{
    //
    protected $fillable = [
        'user_id', 'full_name', 'likes', 'diselikes'
    ];

    public function users(){
        return $this->belongsTo('App\User');
    }
}
