<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a Stripe Checkout Session
     */
    public function createCheckoutSession(array $lineItems, string $orderRef, array $customerData, string $successUrl, string $cancelUrl): Session
    {
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'customer_email' => $customerData['email'] ?? null,
                'metadata' => [
                    'order_ref' => $orderRef,
                    'first_name' => $customerData['first_name'] ?? '',
                    'last_name' => $customerData['last_name'] ?? '',
                ],
                'shipping_address_collection' => [
                    'allowed_countries' => ['US', 'CA', 'GB', 'AU', 'PK', 'AE'],
                ],
            ]);

            return $session;
        } catch (ApiErrorException $e) {
            Log::error('Stripe Checkout Session creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Retrieve a Stripe Checkout Session
     */
    public function retrieveSession(string $sessionId): Session
    {
        try {
            return Session::retrieve($sessionId);
        } catch (ApiErrorException $e) {
            Log::error('Stripe Session retrieval failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Format line items for Stripe
     */
    public function formatLineItems(array $cartItems): array
    {
        return array_map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                            'images' => $item['image'] ? [image_url($item['image'])] : [],
                    ],
                    'unit_amount' => (int)($item['price'] * 100), // Convert to cents
                ],
                'quantity' => (int)$item['qty'],
            ];
        }, $cartItems);
    }
}

