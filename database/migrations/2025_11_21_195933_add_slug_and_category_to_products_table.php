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
        Schema::table('products', function (Blueprint $table) {
            // Add slug if it does not exist
            if (!Schema::hasColumn('products', 'slug')) {
                $table->string('slug')->unique()->after('id');
            }

            // Add category if it does not exist
            if (!Schema::hasColumn('products', 'category')) {
                $table->string('category')->nullable()->after('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'slug')) {
                $table->dropColumn('slug');
            }
            if (Schema::hasColumn('products', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};
