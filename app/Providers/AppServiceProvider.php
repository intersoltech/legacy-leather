<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share common data with all views
        view()->composer('*', function ($view) {
            $view->with([
                'siteSettings' => $this->getSiteSettings(),
                'categories' => \App\Models\Category::where('is_active', true)->orderBy('order')->get(),
                'socialLinks' => \App\Models\SocialLink::where('is_active', true)->orderBy('order')->get(),
            ]);
        });
    }
    
    private function getSiteSettings()
    {
        return [
            'site_name' => \App\Models\SiteSetting::get('site_name', 'Legacy Leather Works'),
            'site_logo' => \App\Models\SiteSetting::get('site_logo', 'assets/img/logo.png'),
            'marquee_text' => \App\Models\SiteSetting::get('marquee_text', 'Worldwide Shipping•Easy Returns•Premium Leather Craftsmanship•Legacy Leather Works'),
            'whatsapp_number' => \App\Models\SiteSetting::get('whatsapp_number', '+92 300 0000000'),
            'whatsapp_url' => \App\Models\SiteSetting::get('whatsapp_url', 'https://wa.me/923000000000'),
            'email' => \App\Models\SiteSetting::get('email', 'support@legacyleatherworks.com'),
            'contact_email' => \App\Models\SiteSetting::get('contact_email', 'Legacyleathergoods@gmail.com'),
            'footer_description' => \App\Models\SiteSetting::get('footer_description', 'Premium leather goods crafted for an international lifestyle — timeless silhouettes, clean finishing, and luxury materials.'),
            'copyright_text' => \App\Models\SiteSetting::get('copyright_text', 'Legacy Leather Works. All rights reserved.'),
            'payment_methods' => explode(',', \App\Models\SiteSetting::get('payment_methods', 'VISA,MASTERCARD,STRIPE,COD')),
            'currencies' => explode(',', \App\Models\SiteSetting::get('currencies', 'AED,USD,PKR,GBP')),
            'default_currency' => \App\Models\SiteSetting::get('default_currency', 'USD'),
            'newsletter_text' => \App\Models\SiteSetting::get('newsletter_text', 'Get early access to new arrivals and exclusive offers.'),
        ];
    }
}
