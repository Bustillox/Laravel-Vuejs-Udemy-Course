<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Modelo de Categorias
class Category extends Model
{
    //
    protected $table = 'categories';
    protected $fillable = ['name', 'description', 'condition'];
}
