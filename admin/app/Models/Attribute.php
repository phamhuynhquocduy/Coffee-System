<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Attribute extends Model
{
    use HasFactory;

    protected $table = "attributes";

    public $timestamps = false;

    protected $fillable = array('name_attr');

    protected static function booted()
    {
        static::deleting(function ($product){
            $product->products()->detach();
        });

        // Lưu ý khi xóa sản phẩm thì giá trị trong bảng product_attribute cũng phải xóa theo tương ứng
    }

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'attribute_values',
            'id_attribute',
            'id_product'
        )->withPivot('name_attr_value', 'price_attr_value');
    }
}
