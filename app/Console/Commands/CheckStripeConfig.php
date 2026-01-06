<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckStripeConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Stripe configuration keys';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Stripe Configuration Check ===');
        $this->newLine();

        $stripeKey = config('services.stripe.key');
        $stripeSecret = config('services.stripe.secret');
        $stripeWebhook = config('services.stripe.webhook_secret');

        // Check STRIPE_KEY
        $this->checkKey('STRIPE_KEY', $stripeKey, 'pk_');

        // Check STRIPE_SECRET
        $this->checkKey('STRIPE_SECRET', $stripeSecret, 'sk_');

        // Check STRIPE_WEBHOOK_SECRET
        $this->checkKey('STRIPE_WEBHOOK_SECRET', $stripeWebhook, 'whsec_');

        $this->newLine();
        
        $placeholders = [
            'your_stripe_publishable_key',
            'your_stripe_secret_key',
            'your_webhook_secret',
            'your_stripe_key',
            'your_stripe_secret',
        ];
        
        $isConfigured = $stripeKey && $stripeSecret && $stripeWebhook
            && !in_array(strtolower($stripeKey), array_map('strtolower', $placeholders))
            && !in_array(strtolower($stripeSecret), array_map('strtolower', $placeholders))
            && !in_array(strtolower($stripeWebhook), array_map('strtolower', $placeholders))
            && str_starts_with($stripeKey, 'pk_')
            && str_starts_with($stripeSecret, 'sk_')
            && str_starts_with($stripeWebhook, 'whsec_');
        
        if (!$isConfigured) {
            $this->warn('⚠️  Stripe keys are not properly configured!');
            $this->newLine();
            $this->info('Add these to your .env file:');
            $this->line('STRIPE_KEY=pk_test_your_publishable_key_here');
            $this->line('STRIPE_SECRET=sk_test_your_secret_key_here');
            $this->line('STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here');
            $this->newLine();
            $this->info('Get your keys from: https://dashboard.stripe.com/apikeys');
            $this->info('Get webhook secret from: https://dashboard.stripe.com/webhooks');
            return 1;
        } else {
            $this->info('✅ All Stripe keys are properly configured!');
            return 0;
        }

        return 0;
    }

    protected function checkKey(string $name, ?string $value, string $prefix): void
    {
        $placeholders = [
            'your_stripe_publishable_key',
            'your_stripe_secret_key',
            'your_webhook_secret',
            'your_stripe_key',
            'your_stripe_secret',
        ];

        if (!$value || in_array(strtolower($value), array_map('strtolower', $placeholders))) {
            $this->error("✗ {$name}: NOT SET or using placeholder");
        } elseif (!str_starts_with($value, $prefix)) {
            $this->warn("⚠️  {$name}: SET but invalid format (should start with '{$prefix}')");
            $this->line("   Value: " . substr($value, 0, 20) . '...');
        } else {
            $this->info("✓ {$name}: SET and valid format");
            $this->line("   Value: " . substr($value, 0, 20) . '...');
        }
    }
}
