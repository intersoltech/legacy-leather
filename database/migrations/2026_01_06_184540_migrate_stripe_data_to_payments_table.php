<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Migrate existing Stripe payment data from orders table to payments table
     */
    public function up(): void
    {
        // Only migrate if orders table has stripe fields
        if (Schema::hasColumn('orders', 'stripe_session_id')) {
            // Get all orders with Stripe payment data
            $orders = DB::table('orders')
                ->where('payment_method', 'stripe')
                ->whereNotNull('stripe_session_id')
                ->get();

            foreach ($orders as $order) {
                // Determine payment status based on order status
                $paymentStatus = 'pending';
                if ($order->status === 'paid') {
                    $paymentStatus = 'completed';
                } elseif ($order->status === 'failed') {
                    $paymentStatus = 'failed';
                }

                // Insert payment record
                DB::table('payments')->insert([
                    'order_id' => $order->id,
                    'payment_method' => 'stripe',
                    'provider' => 'stripe',
                    'status' => $paymentStatus,
                    'amount' => $order->total,
                    'currency' => $order->currency ?? 'USD',
                    'provider_session_id' => $order->stripe_session_id,
                    'provider_payment_id' => $order->stripe_payment_intent_id,
                    'provider_customer_id' => $order->stripe_customer_id,
                    'paid_at' => $paymentStatus === 'completed' ? $order->updated_at : null,
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete payments that were migrated (those with provider = 'stripe')
        // Note: This is a data migration, so we can't fully reverse it
        // But we can delete the migrated payments if needed
        DB::table('payments')->where('provider', 'stripe')->delete();
    }
};
