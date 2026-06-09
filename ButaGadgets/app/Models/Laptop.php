<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'processor_id', 'video_card_id', 'ram_id', 
        'storage_id', 'screen_size_id', 'screen_type_id', 'operating_system_id', 'color_id'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
