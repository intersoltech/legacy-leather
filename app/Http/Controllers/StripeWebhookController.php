<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use App\Services\StripeService;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Handle Stripe webhook events
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid Stripe webhook payload: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            Log::error('Invalid Stripe webhook signature: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($event->data->object);
                break;

            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event->data->object);
                break;

            case 'payment_intent.payment_failed':
                $this->handlePaymentIntentFailed($event->data->object);
                break;

            default:
                Log::info('Unhandled Stripe webhook event: ' . $event->type);
        }

        return response()->json(['received' => true]);
    }

    /**
     * Handle checkout session completed
     */
    protected function handleCheckoutSessionCompleted($session)
    {
        $payment = Payment::where('provider_session_id', $session->id)->first();

        if ($payment) {
            $payment->update([
                'status' => 'completed',
                'provider_payment_id' => $session->payment_intent,
                'provider_customer_id' => $session->customer ?? null,
                'paid_at' => now(),
            ]);

            // Update order status
            $payment->order->update([
                'status' => 'paid',
            ]);

            Log::info('Order ' . $payment->order->order_ref . ' marked as paid via Stripe webhook');
        }
    }

    /**
     * Handle payment intent succeeded
     */
    protected function handlePaymentIntentSucceeded($paymentIntent)
    {
        $payment = Payment::where('provider_payment_id', $paymentIntent->id)->first();

        if ($payment && $payment->status !== 'completed') {
            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            // Update order status
            $payment->order->update([
                'status' => 'paid',
            ]);

            Log::info('Order ' . $payment->order->order_ref . ' payment confirmed via Stripe webhook');
        }
    }

    /**
     * Handle payment intent failed
     */
    protected function handlePaymentIntentFailed($paymentIntent)
    {
        $payment = Payment::where('provider_payment_id', $paymentIntent->id)->first();

        if ($payment) {
            $payment->update([
                'status' => 'failed',
                'failure_reason' => $paymentIntent->last_payment_error->message ?? 'Payment failed',
                'failed_at' => now(),
            ]);

            // Update order status
            $payment->order->update([
                'status' => 'failed',
            ]);

            Log::warning('Order ' . $payment->order->order_ref . ' payment failed via Stripe webhook');
        }
    }
}
