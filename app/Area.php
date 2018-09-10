<?php

namespace App;

use App\Model;

class Area extends Model
{
    protected $primaryKey = 'area_id';
    protected $guarded = ['area_id'];
    
    public function parents()
    {
        return $this->hasMany('App\\Area', 'area_id', 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany('App\\Area', 'parent_id', 'area_id');
    }
}
