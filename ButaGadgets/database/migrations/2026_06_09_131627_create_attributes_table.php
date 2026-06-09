<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
        
        // Прив'язка до категорії (наприклад, "Смартфони")
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        
        // Назва атрибута (наприклад, "Процесор", "ОЗУ")
        $table->string('name');
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
