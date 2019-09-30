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

    public function departaments()
    {
        return $this->hasMany('App\People');
    }

    public function departament_people()
    {
        return $this->departaments()->attach($departament_id);
    }

}
