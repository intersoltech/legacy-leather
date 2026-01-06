# Stripe Checkout Integration Setup Guide

## Overview
Stripe Checkout has been successfully integrated into your Laravel application. This allows customers to pay securely using credit/debit cards through Stripe's hosted checkout page.

## What Was Implemented

### 1. **Stripe PHP SDK**
- Installed `stripe/stripe-php` package (v19.1.0)

### 2. **Database Changes**
- Migration created: `add_stripe_fields_to_orders_table.php`
- Added fields to `orders` table:
  - `stripe_session_id` - Stores Stripe checkout session ID
  - `stripe_payment_intent_id` - Stores payment intent ID
  - `stripe_customer_id` - Stores customer ID (if applicable)

### 3. **Services**
- Created `App\Services\StripeService` for Stripe API interactions
- Handles checkout session creation and retrieval

### 4. **Controllers**
- Updated `CheckoutController` with Stripe payment handling
- Created `StripeWebhookController` for webhook events

### 5. **Routes**
- `/checkout/stripe/success` - Success callback
- `/checkout/stripe/cancel` - Cancellation callback
- `/webhook/stripe` - Webhook endpoint (CSRF excluded)

### 6. **Configuration**
- Added Stripe config to `config/services.php`
- Updated `bootstrap/app.php` to exclude webhook from CSRF

### 7. **Views**
- Updated checkout form with "Credit/Debit Card (Stripe)" option

## Setup Instructions

### Step 1: Get Stripe API Keys

1. Sign up for a Stripe account at https://stripe.com
2. Go to Developers → API keys
3. Copy your **Publishable key** and **Secret key**
4. For webhooks, you'll need a **Webhook signing secret**

### Step 2: Configure Environment Variables

Add these to your `.env` file:

```env
STRIPE_KEY=pk_test_your_publishable_key_here
STRIPE_SECRET=sk_test_your_secret_key_here
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
```

**For Production:**
- Use `pk_live_...` and `sk_live_...` keys
- Update webhook secret for production endpoint

### Step 3: Run Migration

```bash
php artisan migrate
```

This will add the Stripe fields to your orders table.

### Step 4: Set Up Stripe Webhook

1. Go to Stripe Dashboard → Developers → Webhooks
2. Click "Add endpoint"
3. Enter your webhook URL: `https://yourdomain.com/webhook/stripe`
4. Select events to listen to:
   - `checkout.session.completed`
   - `payment_intent.succeeded`
   - `payment_intent.payment_failed`
5. Copy the **Signing secret** and add it to `.env` as `STRIPE_WEBHOOK_SECRET`

### Step 5: Test the Integration

**Test Mode:**
- Use test card: `4242 4242 4242 4242`
- Any future expiry date (e.g., 12/34)
- Any 3-digit CVC
- Any ZIP code

**Test Scenarios:**
- Successful payment: Use card `4242 4242 4242 4242`
- Declined payment: Use card `4000 0000 0000 0002`
- Requires authentication: Use card `4000 0025 0000 3155`

## How It Works

### Payment Flow

1. **Customer selects "Credit/Debit Card (Stripe)"** in checkout
2. **Order is created** with status "pending"
3. **Stripe Checkout Session is created** with order items
4. **Customer is redirected** to Stripe's hosted checkout page
5. **Customer completes payment** on Stripe
6. **Stripe redirects back** to success/cancel URL
7. **Webhook confirms payment** and updates order status to "paid"

### Order Status Flow

- `pending` - Order created, awaiting payment
- `paid` - Payment successful (via webhook or success callback)
- `failed` - Payment failed (via webhook)

## Security Features

- ✅ Webhook signature verification
- ✅ CSRF protection (webhook excluded)
- ✅ Secure API key storage in environment
- ✅ Payment intent tracking
- ✅ Order status validation

## Troubleshooting

### Webhook Not Working
- Verify webhook URL is accessible
- Check webhook secret matches in `.env`
- Review Stripe Dashboard → Webhooks for event logs
- Check Laravel logs: `storage/logs/laravel.log`

### Payment Not Completing
- Verify Stripe keys are correct
- Check order is created before redirect
- Ensure success/cancel URLs are accessible
- Review browser console for errors

### Test Mode vs Production
- Test mode: Use `pk_test_` and `sk_test_` keys
- Production: Use `pk_live_` and `sk_live_` keys
- Update webhook endpoint for production domain

## Support

For Stripe-specific issues:
- Stripe Documentation: https://stripe.com/docs
- Stripe Support: https://support.stripe.com

For application issues:
- Check Laravel logs
- Review webhook events in Stripe Dashboard
- Verify database migrations ran successfully

