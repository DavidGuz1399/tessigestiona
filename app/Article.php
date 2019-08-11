<?php

namespace Tessigestiona;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function category(){
        return $this->belongsTo('Tessigestiona\Category');
    }
}
