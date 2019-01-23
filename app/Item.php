<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'category_id', 'code', 'name', 'sale_price', 'stock', 'description', 'condition'
    ];

    public function category(){
        return $this->belongsTo('App\Category');
    }
}
