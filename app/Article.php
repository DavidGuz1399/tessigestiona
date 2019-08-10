<?php

namespace Tessigestiona;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function categories(){
        return $this->hasMany('Tessigestiona\Category');
    }
}
