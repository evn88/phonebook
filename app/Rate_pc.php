<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate_pc extends Model
{
    protected $table = 'rate_pc';
    protected $perPage = 50; 

    public function article_pc() {
        return $this->belongsTo('App\Article_pc', 'pc_id', 'id'); //'local_key', 'parent_key'
    }

    public function scopeConfirmed($query)
    {
        return $query->whereConfirmed(true);
    }
}
