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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
            ->unique()
            ->constrained()
            ->cascadeOnDelete();
  
            $table->foreignId('processor_id')->constrained();
            $table->foreignId('video_card_id')->constrained();
            $table->foreignId('ram_id')->constrained();
            $table->foreignId('storage_id')->constrained();
            $table->foreignId('screen_size_id')->constrained();
            $table->foreignId('screen_type_id')->constrained();
            $table->foreignId('operating_system_id')->constrained();
            $table->foreignId('color_id')->constrained();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
