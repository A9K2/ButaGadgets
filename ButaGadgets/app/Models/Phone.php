<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'processor_id', 'ram_id', 'storage_id', 
        'battery_id', 'color_id', 'screen_type_id', 'operating_system_id'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
