<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //Model relationship
    //many posts belong to one user. Many blogs -> ONE user
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
