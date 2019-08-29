<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate_orgtech extends Model
{
    protected $table = 'rate_orgtech';

    public function article_orgtech() {
        return $this->belongsTo('App\Article_orgtech', 'orgtech_id');
    }

    public function scopeConfirmed($query)
    {
        return $query->whereConfirmed(true);
    }
}
