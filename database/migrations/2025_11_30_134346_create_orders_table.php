<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Optional user link
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Customer details
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->text('address');

            // Order details
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['Pending', 'Processing', 'Completed', 'Cancelled'])->default('Pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
