<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('order_ref')->unique();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');

            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('postal_code')->nullable();

            $table->string('payment_method')->default('cod');
            $table->string('currency')->default('USD');

            $table->integer('subtotal');
            $table->integer('shipping')->default(0);
            $table->integer('total');

            $table->text('notes')->nullable();
            $table->string('status')->default('received');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
