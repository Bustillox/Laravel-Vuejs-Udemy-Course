<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'document_type', 'document_number', 'address', 'phone', 'email'];

    public function provider(){
        return $this->hasOne('App\Provider');
    }

}
