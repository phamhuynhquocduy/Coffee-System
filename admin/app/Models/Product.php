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

    protected static function booted()
    {
        static::deleting(function ($product){
            $product->attrs()->detach();
        });

        // Lưu ý khi xóa sản phẩm thì giá trị trong bảng product_attribute cũng phải xóa theo tương ứng

    }

    public function attrs()
    {
        return $this->belongsToMany(
            Attribute::class,
            'attribute_values',
            'id_product',
            'id_attribute'
        )->withPivot('name_attr_value', 'price_attr_value');
    }
}
