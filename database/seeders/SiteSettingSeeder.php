<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Site Info
            ['key' => 'site_name', 'value' => 'Legacy Leather Works', 'type' => 'text'],
            ['key' => 'site_logo', 'value' => 'assets/img/logo.png', 'type' => 'text'],
            
            // Topbar Marquee
            ['key' => 'marquee_text', 'value' => 'Worldwide Shipping•Easy Returns•Premium Leather Craftsmanship•Legacy Leather Works', 'type' => 'text'],
            
            // Contact Info
            ['key' => 'whatsapp_number', 'value' => '+92 300 0000000', 'type' => 'phone'],
            ['key' => 'whatsapp_url', 'value' => 'https://wa.me/923000000000', 'type' => 'url'],
            ['key' => 'email', 'value' => 'support@legacyleatherworks.com', 'type' => 'email'],
            ['key' => 'contact_email', 'value' => 'Legacyleathergoods@gmail.com', 'type' => 'email'],
            
            // Footer
            ['key' => 'footer_description', 'value' => 'Premium leather goods crafted for an international lifestyle — timeless silhouettes, clean finishing, and luxury materials.', 'type' => 'text'],
            ['key' => 'copyright_text', 'value' => 'Legacy Leather Works. All rights reserved.', 'type' => 'text'],
            
            // Payment Methods
            ['key' => 'payment_methods', 'value' => 'VISA,MASTERCARD,STRIPE,COD', 'type' => 'text'],
            
            // Currency Options
            ['key' => 'currencies', 'value' => 'AED,USD,PKR,GBP', 'type' => 'text'],
            ['key' => 'default_currency', 'value' => 'USD', 'type' => 'text'],
            
            // About Page
            ['key' => 'about_hero_title', 'value' => 'Crafted to last. Designed to feel luxury.', 'type' => 'text'],
            ['key' => 'about_hero_description', 'value' => 'Legacy Leather Works is built on timeless silhouettes, premium materials, and clean finishing. We believe leather should age beautifully — every stitch, every edge, and every detail is made to feel refined and elevated.', 'type' => 'text'],
            ['key' => 'about_story', 'value' => 'Legacy Leather Works was born from a childhood memory — watching a father transform raw leather into something meaningful. To him, leather was never just material; it was a promise of quality, patience, and longevity. That same spirit lives on today. Every piece we create is handcrafted from premium leather with care, honesty, and respect for true craftsmanship. We don\'t rush the process, and we don\'t treat orders as transactions — each one is part of a continuing legacy. When you choose Legacy Leather Works, you\'re not just buying leather. You\'re holding a memory. A tradition.', 'type' => 'text'],
            
            // Contact Page
            ['key' => 'contact_working_hours', 'value' => 'Mon – Sat: 10:00 AM – 7:00 PM<br/>Sunday: Closed', 'type' => 'text'],
            ['key' => 'contact_address', 'value' => 'Your Studio / Office Address Here<br/>City, Country', 'type' => 'text'],
            ['key' => 'contact_map_embed', 'value' => 'https://www.google.com/maps?q=lahore&output=embed', 'type' => 'url'],
            
            // Newsletter
            ['key' => 'newsletter_text', 'value' => 'Get early access to new arrivals and exclusive offers.', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
