<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \SleepingOwl\Admin\Traits\OrderableModel;

class People extends Model
{
    protected $hidden = ['deleted_at','created_at', 'updated_at', 'order'];
    protected $dates = ['created_at', 'updated_at', 'birthday'];
    protected $dateFormat = 'd.m.Y';

    public function filial()
    {
        return $this->belongsTo('App\Filial');
    }

    public function departament()
    {
        return $this->belongsTo('App\Departament');
    }



}
