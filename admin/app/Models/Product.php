<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    public $timestamps = false;

    protected $fillable = array('name', 'price', 'status');

    public function attrs()
    {
        return $this->belongsToMany(
            Attribute::class,
            'attribute_values',
            'id_product',
            'id_attribute'
        )->withPivot('name_attr_value','price_attr_value');
    }
}
