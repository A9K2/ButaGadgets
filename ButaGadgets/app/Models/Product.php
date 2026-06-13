<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Вказуємо поля з вашої схеми для масового заповнення
    protected $fillable = [
        'name', 'brand_id', 'category_id', 'subcategory_id', 
        'price', 'old_price', 'quantity', 'description', 
        'image', 'is_popular', 'is_action'
    ];
    

    // Зв'язок з відгуками (корисна штука для AdminReviewController)
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
    public function images() {
        return $this->hasMany(ProductImage::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);  // або як називається модель
    }

    public function value()
    {
        return $this->belongsTo(AttributeValue::class);  // або як називається модель
    }
}