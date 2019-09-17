<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \SleepingOwl\Admin\Traits\OrderableModel;

class Filial extends Model
{
    public function people()
    {
        return $this->hasOne('App\People');
    }
}
