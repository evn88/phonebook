<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article_pc extends Model
{
    protected $table = 'article_pc';
    protected $perPage = 50; 

    public function rate_pc() {
        return $this->hasMany('App\Rate_pc', 'pc_id');
    }
}
