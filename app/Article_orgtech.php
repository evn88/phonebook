<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article_orgtech extends Model
{
    protected $table = 'article_orgtech';

    public function rate_orgtech() {
        return $this->hasMany('App\Rate_orgtech', 'orgtech_id');
    }
}
