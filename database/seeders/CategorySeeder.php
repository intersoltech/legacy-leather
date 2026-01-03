<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'all',
                'slug' => 'all',
                'display_name' => 'All',
                'order' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'men',
                'slug' => 'men',
                'display_name' => 'Men',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'women',
                'slug' => 'women',
                'display_name' => 'Women',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'wallet',
                'slug' => 'wallet',
                'display_name' => 'Wallet',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'office accessories',
                'slug' => 'office-accessories',
                'display_name' => 'Office Accessories',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'table runner',
                'slug' => 'table-runner',
                'display_name' => 'Table Runner',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'key chains',
                'slug' => 'key-chains',
                'display_name' => 'Key Chains',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
