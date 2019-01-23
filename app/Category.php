<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Modelo de Categorias
class Category extends Model
{
    //
    protected $table = 'categories';
    protected $fillable = ['name', 'description', 'condition'];

    public function items()
    {
        return $this->hasMany('App\Item');
    }

}
