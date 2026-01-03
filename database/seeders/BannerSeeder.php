<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            // Shop page banners
            [
                'title' => 'Jackets • Timeless Leather',
                'kicker' => 'Men',
                'subtitle' => 'Classic silhouettes crafted for daily wear.',
                'image' => 'assets/img/banner.png',
                'category_filter' => 'men',
                'button_text' => 'Shop Men',
                'button_link' => '/shop?cat=men',
                'order' => 1,
                'is_active' => true,
                'type' => 'shop',
            ],
            [
                'title' => 'Blazers • Modern Cuts',
                'kicker' => 'Women',
                'subtitle' => 'Luxury finishing, premium comfort.',
                'image' => 'assets/img/banner.png',
                'category_filter' => 'women',
                'button_text' => 'Shop Women',
                'button_link' => '/shop?cat=women',
                'order' => 2,
                'is_active' => true,
                'type' => 'shop',
            ],
            [
                'title' => 'Desk Sets • Wallets • Keychains',
                'kicker' => 'Accessories',
                'subtitle' => 'Elevate your space with leather luxury.',
                'image' => 'assets/img/banner.png',
                'category_filter' => 'office accessories',
                'button_text' => 'Office',
                'button_link' => '/shop?cat=office%20accessories',
                'order' => 3,
                'is_active' => true,
                'type' => 'shop',
            ],
            // Home page hero images
            [
                'title' => null,
                'kicker' => null,
                'subtitle' => null,
                'image' => 'assets/img/banner.png',
                'category_filter' => null,
                'button_text' => null,
                'button_link' => null,
                'order' => 1,
                'is_active' => true,
                'type' => 'home',
            ],
            [
                'title' => null,
                'kicker' => null,
                'subtitle' => null,
                'image' => 'assets/img/esha.jpg',
                'category_filter' => null,
                'button_text' => null,
                'button_link' => null,
                'order' => 2,
                'is_active' => true,
                'type' => 'home',
            ],
            [
                'title' => null,
                'kicker' => null,
                'subtitle' => null,
                'image' => 'assets/img/1.jpg',
                'category_filter' => null,
                'button_text' => null,
                'button_link' => null,
                'order' => 3,
                'is_active' => true,
                'type' => 'home',
            ],
            [
                'title' => null,
                'kicker' => null,
                'subtitle' => null,
                'image' => 'assets/img/banner3.png',
                'category_filter' => null,
                'button_text' => null,
                'button_link' => null,
                'order' => 4,
                'is_active' => true,
                'type' => 'home',
            ],
        ];

        foreach ($banners as $banner) {
            Banner::updateOrCreate(
                [
                    'type' => $banner['type'],
                    'order' => $banner['order'],
                ],
                $banner
            );
        }
    }
}
