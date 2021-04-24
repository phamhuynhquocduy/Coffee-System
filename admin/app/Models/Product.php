<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    public $timestamps = false;

    public function attribute_values(){
        return $this->hasMany('App\Models\AttributeValues', 'id_product', 'id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category', 'id_category', 'id');
    }
}
