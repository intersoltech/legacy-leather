# Payments Table Architecture

## Overview
A separate `payments` table has been created to handle all payment methods (Stripe, PayPal, COD, Bank Transfer, etc.) in a scalable and flexible way.

## Benefits

1. **Multiple Payment Methods**: Support for Stripe, PayPal, COD, Bank Transfer, and future payment providers
2. **Payment History**: Track all payment attempts for an order
3. **Refunds Support**: Can track refunded payments
4. **Better Analytics**: Separate payment data for reporting
5. **Scalability**: Easy to add new payment providers without modifying orders table

## Database Structure

### Payments Table

```sql
- id (primary key)
- order_id (foreign key to orders)
- payment_method (stripe, paypal, cod, bank, etc.)
- provider (stripe, paypal, null for cod/bank)
- status (pending, processing, completed, failed, refunded, cancelled)
- amount (in cents)
- currency (USD, etc.)
- provider_session_id (Stripe session ID, PayPal order ID, etc.)
- provider_payment_id (Stripe payment intent, PayPal transaction ID, etc.)
- provider_customer_id (Stripe customer ID, PayPal payer ID, etc.)
- transaction_data (JSON for provider-specific data)
- failure_reason (if payment failed)
- paid_at (timestamp)
- failed_at (timestamp)
- timestamps
```

## Migration Order

1. ✅ `create_payments_table` - Creates the payments table
2. ✅ `migrate_stripe_data_to_payments_table` - Migrates existing Stripe data from orders
3. ✅ `remove_stripe_fields_from_orders_table` - Removes Stripe fields from orders table

## Model Relationships

### Order Model
```php
$order->payments() // All payments for this order
$order->latestPayment() // Most recent payment
$order->successfulPayment() // Completed payment
```

### Payment Model
```php
$payment->order() // The order this payment belongs to
$payment->isSuccessful() // Check if payment is completed
$payment->isPending() // Check if payment is pending
$payment->isFailed() // Check if payment failed
```

## Usage Examples

### Creating a Payment

```php
// Stripe Payment
Payment::create([
    'order_id' => $order->id,
    'payment_method' => 'stripe',
    'provider' => 'stripe',
    'status' => 'pending',
    'amount' => 10000, // $100.00 in cents
    'currency' => 'USD',
    'provider_session_id' => $sessionId,
]);

// COD Payment
Payment::create([
    'order_id' => $order->id,
    'payment_method' => 'cod',
    'provider' => null,
    'status' => 'pending',
    'amount' => 10000,
    'currency' => 'USD',
]);
```

### Updating Payment Status

```php
$payment->update([
    'status' => 'completed',
    'provider_payment_id' => $paymentIntentId,
    'paid_at' => now(),
]);
```

### Querying Payments

```php
// Get all successful payments
Payment::where('status', 'completed')->get();

// Get payments for an order
$order->payments;

// Get latest payment for an order
$order->latestPayment;

// Get successful payment
$order->successfulPayment;
```

## Payment Status Flow

1. **pending** - Payment initiated, awaiting completion
2. **processing** - Payment is being processed
3. **completed** - Payment successful
4. **failed** - Payment failed
5. **refunded** - Payment was refunded
6. **cancelled** - Payment was cancelled

## Adding New Payment Providers

To add a new payment provider (e.g., PayPal):

1. Create payment record with `provider = 'paypal'`
2. Store PayPal-specific IDs in `provider_session_id`, `provider_payment_id`
3. Handle webhooks/callbacks to update payment status
4. No changes needed to orders table!

## Migration Notes

- Existing Stripe data has been migrated from orders table to payments table
- Stripe fields removed from orders table
- All new payments are created in payments table
- Backward compatible - existing code updated to use payments table

