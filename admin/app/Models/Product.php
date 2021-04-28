<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    public $timestamps = false;

    public function atrribute_values()
    {
        return $this->belongsToMany('App\Models\AttributeValues');
    }
}
