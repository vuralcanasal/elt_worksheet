<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    function getCategory(){
      return $this->hasOne('App\Models\Article','id','article');
    }
}
