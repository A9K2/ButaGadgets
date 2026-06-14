<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subcategory;
use App\Models\Product;

class Category extends Model
{
    
    protected $fillable = ['name'];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function attributes()
    {
        return $this->hasMany(\App\Models\Attribute::class, 'category_id');
    }
    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }
}
