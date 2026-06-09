<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeValue extends Model
{
    protected $fillable = ['attribute_id', 'value'];

    // Значення належить конкретному атрибуту
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    // Значення можуть належати багатьом товарам
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_attribute_value');
    }
}