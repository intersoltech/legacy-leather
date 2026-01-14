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
        // Add indexes to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('status');
            $table->index('created_at');
            $table->index('order_ref');
        });

        // Add indexes to products table
        Schema::table('products', function (Blueprint $table) {
            $table->index('category');
            $table->index('is_active');
            $table->index('slug');
        });

        // Add indexes to order_items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('product_id');
        });

        // Add indexes to cart_items table
        Schema::table('cart_items', function (Blueprint $table) {
            $table->index('cart_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['order_ref']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['slug']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropIndex(['cart_id']);
            $table->dropIndex(['product_id']);
        });
    }
};
