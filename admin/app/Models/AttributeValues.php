<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValues extends Model
{
    use HasFactory;

    protected $table = "attribute_values";

    public function product(){
        return $this->belongsTo('App\Models\Product', 'id_product', 'id');
    }

    public function attribute(){
        return $this->belongsTo('App\Models\Attribute', 'id_attribute', 'id');
    }
}
