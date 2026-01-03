<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SocialLink;

class SocialLinkSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            [
                'platform' => 'Instagram',
                'url' => '#',
                'icon_text' => 'IG',
                'icon_class' => 'bi-instagram',
                'aria_label' => 'Instagram',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'platform' => 'Facebook',
                'url' => '#',
                'icon_text' => 'FB',
                'icon_class' => 'bi-facebook',
                'aria_label' => 'Facebook',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'platform' => 'TikTok',
                'url' => '#',
                'icon_text' => 'TT',
                'icon_class' => 'bi-tiktok',
                'aria_label' => 'TikTok',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'platform' => 'YouTube',
                'url' => '#',
                'icon_text' => 'YT',
                'icon_class' => 'bi-youtube',
                'aria_label' => 'YouTube',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($links as $link) {
            SocialLink::updateOrCreate(
                ['platform' => $link['platform']],
                $link
            );
        }
    }
}
