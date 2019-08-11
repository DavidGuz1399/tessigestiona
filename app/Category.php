<?php

namespace Tessigestiona;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function articles(){
        return $this->hasMany('Tessigestiona\Article');
    }
}
