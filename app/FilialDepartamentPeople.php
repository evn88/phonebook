<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \SleepingOwl\Admin\Traits\OrderableModel;

class FilialDepartamentPeople extends Model
{
    protected $hidden = ['deleted_at','created_at', 'updated_at'];

    public function people()
    {
        return $this->belongsTo('App\People');
    }

    public function filial()
    {
        return $this->belongsTo('App\Filial');
    }

    public function departament()
    {
        return $this->belongsTo('App\Departament');
    }


}
