<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;

class AttributeValue extends Model
{
    use HasFactory;

    protected $table = "attribute_values";

    public $timestamps = false;

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'id_attribute', 'id');
    }
}
