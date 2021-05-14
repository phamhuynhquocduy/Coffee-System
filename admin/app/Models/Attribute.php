<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeValue;

class Attribute extends Model
{
    use HasFactory;

    protected $table = "attributes";

    public $timestamps = false;

    protected $fillable = array('name_attr');

    protected static function booted()
    {
        static::deleting(function ($attribute){
            $attribute->attr_values()->detach();
        });

        // Lưu ý khi xóa sản phẩm thì giá trị trong bảng product_attribute cũng phải xóa theo tương ứng
    }

    public function attr_values()
    {
        return $this->hasMany(AttributeValue::class, 'id_attribute', 'id');
    }
}
