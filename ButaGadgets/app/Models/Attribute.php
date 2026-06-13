<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Додайте цей метод, щоб Laravel знав, що у атрибута є значення
    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}