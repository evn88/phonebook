<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \SleepingOwl\Admin\Traits\OrderableModel;

class Departament extends Model
{
    protected $hidden = ['deleted_at','created_at', 'updated_at', 'order'];

    public function people()
    {
        return $this->hasOne('App\People');
    }

    public function filial()
    {
        return $this->belongsTo('App\Filial');
    }


}
