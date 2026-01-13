<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        // Fix for MySQL key length issue with utf8mb4
        Schema::defaultStringLength(191);
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
            'contact_address' => \App\Models\SiteSetting::get('contact_address', 'Your Studio / Office Address Here<br/>City, Country'),
            'contact_working_hours' => \App\Models\SiteSetting::get('contact_working_hours', 'Mon – Sat: 10:00 AM – 7:00 PM<br/>Sunday: Closed'),
            'contact_map_embed' => \App\Models\SiteSetting::get('contact_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3018.4526627807495!2d-73.40069872296034!3d40.8399844713748!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e828e8e554dacf%3A0xe75990b88c579c38!2s11%20Ingersoll%20St%2C%20Huntington%20Station%2C%20NY%2011746%2C%20USA!5e0!3m2!1sen!2s!4v1768327147007!5m2!1sen!2s'),
            'contact_map_note' => \App\Models\SiteSetting::get('contact_map_note', 'Click on the map to get directions to our studio.'),
        ];
    }
}
