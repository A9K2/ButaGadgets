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
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
        
        // Зв'язок із таблицею attributes (зверніть увагу на foreignId)
        $table->foreignId('attribute_id')->constrained()->onDelete('cascade'); 
        
        // Конкретне значення характеристики
        $table->string('value'); // Сюди піде текст: '1200 об/хв', 'Bluetooth 5.3'
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
};
