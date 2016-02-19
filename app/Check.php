<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    protected $fillable = ['id','check_last', 'times','combos','marks'];
    protected $primaryKey = 'id';
}
