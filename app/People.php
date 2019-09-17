<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \SleepingOwl\Admin\Traits\OrderableModel;

class People extends Model
{
    public function filial()
    {
        return $this->belongsTo('App\Filial');
    }

    public function departament()
    {
        return $this->belongsTo('App\Departament');
    }
}
