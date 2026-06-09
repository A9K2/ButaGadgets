<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Додайте це поле, щоб дозволити запис імені категорії
    protected $fillable = ['name'];

    public function attributes()
    {
        return $this->hasMany(\App\Models\Attribute::class, 'category_id');
    }
}
