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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
            ->nullable() // Дозволяємо порожнє значення
            ->constrained()
            ->nullOnDelete(); // При видаленні користувача ставимо null
  
            $table->decimal('total_price', 10, 2);
            $table->string('shipping_address');
            $table->string('phone');
            $table->string('recipient_name');
            $table->string('status')->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
