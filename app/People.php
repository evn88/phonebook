<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \SleepingOwl\Admin\Traits\OrderableModel;

class People extends Model
{
    public function filial()
    {
        return $this->hasOne('App\Filial');
    }

    public function departament()
    {
        return $this->hasOne('App\Departament');
    }
}
