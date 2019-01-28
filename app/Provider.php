<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $fillable = [
        'id', 'contacto', 'contact_phone' 
    ];

    public $timestamps = false;

    public function customer(){
        return $this->belongsTo('App\Customer');
    }
}
