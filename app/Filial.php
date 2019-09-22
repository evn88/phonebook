<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \SleepingOwl\Admin\Traits\OrderableModel;

class Filial extends Model
{
    protected $hidden = ['deleted_at','created_at', 'updated_at', 'order'];

    public function people()
    {
        return $this->hasOne('App\People');
    }

    public function departament()
    {
        return $this->belongsTo('App\People', 'id', 'departament_id');
    }

}
