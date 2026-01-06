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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            
            // Payment method and provider
            $table->string('payment_method'); // stripe, paypal, cod, bank, etc.
            $table->string('provider')->nullable(); // stripe, paypal, etc. (null for cod, bank)
            
            // Payment status
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'refunded', 'cancelled'])->default('pending');
            
            // Amount information
            $table->integer('amount'); // Amount in cents
            $table->string('currency')->default('USD');
            
            // Provider-specific IDs
            $table->string('provider_session_id')->nullable(); // Stripe session ID, PayPal order ID, etc.
            $table->string('provider_payment_id')->nullable(); // Stripe payment intent, PayPal transaction ID, etc.
            $table->string('provider_customer_id')->nullable(); // Stripe customer ID, PayPal payer ID, etc.
            
            // Transaction details
            $table->text('transaction_data')->nullable(); // JSON data for provider-specific info
            $table->string('failure_reason')->nullable(); // Reason if payment failed
            
            // Timestamps
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('order_id');
            $table->index('status');
            $table->index('payment_method');
            $table->index('provider_session_id');
            $table->index('provider_payment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
