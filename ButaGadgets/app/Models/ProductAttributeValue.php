<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    protected $table = 'product_attribute_value';

    protected $fillable = ['product_id', 'attribute_id', 'attribute_value_id'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function value()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}