<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // Заголовок (напр. "Забери подарунок")
            $table->string('image');             // Шлях до картинки банера
            $table->string('url_link')->nullable(); // Куди веде клік (напр. /category/smartphones)
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0); // Порядок сортування
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
