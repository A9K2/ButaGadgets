<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Оновлюємо таблицю товарів
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('old_price', 10, 2)->nullable()->after('price');
            $table->boolean('is_popular')->default(false)->after('quantity');
            $table->boolean('is_action')->default(false)->after('is_popular');
        });

        // Оновлюємо таблицю категорій (для іконок та плашок на головній)
        Schema::table('categories', function (Blueprint $table) {
            $table->string('icon_class')->nullable()->after('name'); // напр. 'bi-phone', 'bi-laptop'
            $table->boolean('show_on_homepage')->default(false)->after('icon_class'); // для кольорових плашок
            $table->string('homepage_color')->nullable()->after('show_on_homepage'); // колір плашки (напр. #28a745)
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['old_price', 'is_popular', 'is_action']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['icon_class', 'show_on_homepage', 'homepage_color']);
        });
    }
};