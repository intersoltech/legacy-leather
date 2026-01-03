<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('cart_items', function (Blueprint $table) {
      $table->id();
      $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
      $table->string('name');
      $table->integer('price');     // 299 etc
      $table->string('img')->nullable();
      $table->integer('qty')->default(1);
      $table->timestamps();
      $table->index(['cart_id','name']);
    });
  }
  public function down(): void {
    Schema::dropIfExists('cart_items');
  }
};