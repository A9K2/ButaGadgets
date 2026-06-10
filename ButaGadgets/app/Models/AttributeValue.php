<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeValue extends Model
{
    protected $fillable = ['attribute_id', 'value'];

    // Значення належить атрибуту
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    // Зв'язок з товарами через таблицю-посередник
    public function products(): BelongsToMany
    {
        // Вкажіть правильні зовнішні ключі, якщо вони не стандартні
        return $this->belongsToMany(Product::class, 'product_attribute_value', 'attribute_value_id', 'product_id')
                    ->withPivot('attribute_id'); // Якщо в таблиці є attribute_id
    }
}