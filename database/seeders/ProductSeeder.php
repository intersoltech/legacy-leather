<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
  public function run(): void
  {
    $items = [
      [
        'name' => 'Classic Black Jacket',
        'description' => 'Timeless black biker jacket crafted with premium leather and bold metallic detailing.',
        'image' => 'assets/img/M2.jpg',
        'price' => 50,
        'category' => 'men',
      ],
      [
        'name' => 'Brown Aviator Jacket',
        'description' => 'Premium leather • Luxury finish',
        'image' => 'assets/img/b1.jpg',
        'price' => 190,
        'category' => 'men',
      ],
      [
        'name' => 'Blue Bomber Jacket',
        'description' => 'Classic blue bomber jacket with smooth leather finish and a modern, everyday luxury look.',
        'image' => 'assets/img/M1.jpg',
        'price' => 200,
        'category' => 'men',
      ],
      [
        'name' => 'Tan Racer Brown Leather Jacket',
        'description' => 'Premium tan leather racer jacket with refined stitching, sleek zip detailing, and a modern luxury silhouette.',
        'image' => 'assets/img/M4.jpg',
        'price' => 230,
        'category' => 'men',
      ],
      [
        'name' => 'Maroon Leather Coat',
        'description' => 'Elegant maroon leather long coat designed for a refined, sophisticated winter style.',
        'image' => 'assets/img/M3.jpg',
        'price' => 250,
        'category' => 'women',
      ],
      [
        'name' => 'Black Cropped Leather Jacket',
        'description' => 'Elegant black cropped leather jacket with a sleek biker silhouette and refined zip detailing for a bold, modern look.',
        'image' => 'assets/img/j.jpg',
        'price' => 210,
        'category' => 'women',
      ],
      [
        'name' => 'Studded Black Jacket (Back View)',
        'description' => 'Bold black leather jacket with studded detailing, crafted for a powerful and edgy statement look.',
        'image' => 'assets/img/aq.jpeg',
        'price' => 250,
        'category' => 'men',
      ],
      [
        'name' => 'Black Biker Jacket',
        'description' => 'Timeless black biker jacket crafted with premium leather and bold metallic detailing.',
        'image' => 'assets/img/M5.jpg',
        'price' => 240,
        'category' => 'men',
      ],
      [
        'name' => 'Leather Office File',
        'description' => 'Premium leather office file crafted with clean stitching and a refined professional finish.',
        'image' => 'assets/img/P3.jpg',
        'price' => 240,
        'category' => 'office accessories',
      ],
      [
        'name' => 'Leather Key Chains',
        'description' => 'Minimal leather key chains with solid hardware, designed for everyday elegance and durability.',
        'image' => 'assets/img/4jpg.jpg',
        'price' => 120,
        'category' => 'key chains',
      ],
      [
        'name' => 'Leather Table Mat / Runner',
        'description' => 'Luxury leather table mat with a smooth finish, adding warmth and sophistication to your space.',
        'image' => 'assets/img/P1.jpg',
        'price' => 160,
        'category' => 'table runner',
      ],
      [
        'name' => 'Leather Diary / Notebook Cover',
        'description' => 'Luxury leather diary cover with a smooth textured finish, adding elegance and a professional touch.',
        'image' => 'assets/img/3.jpg',
        'price' => 220,
        'category' => 'office accessories',
      ],
      [
        'name' => 'Leather Table Runner',
        'description' => 'Luxury leather table runner with a rich finish, adding elegance and warmth to your dining space.',
        'image' => 'assets/img/1a.jpg',
        'price' => 210,
        'category' => 'table runner',
      ],
      [
        'name' => 'Men\'s Leather Wallet',
        'description' => 'Classic leather wallet with a sleek design, perfect for everyday use and durability.',
        'image' => 'assets/img/6.jpg',
        'price' => 150,
        'category' => 'wallet',
      ],
      [
        'name' => 'Leather Table Mat',
        'description' => 'Premium leather table mat with a smooth surface for a refined and stylish table setting.',
        'image' => 'assets/img/P5.jpg',
        'price' => 125,
        'category' => 'table runner',
      ],
      [
        'name' => 'Men\'s Leather Wallet (Open View)',
        'description' => 'Premium leather wallet with multiple card slots and compartments for organized storage.',
        'image' => 'assets/img/7.jpg',
        'price' => 150,
        'category' => 'wallet',
      ],
      [
        'name' => 'Women\'s Leather Long Wallet',
        'description' => 'Elegant leather long wallet with spacious compartments and a secure button closure.',
        'image' => 'assets/img/P6.jpg',
        'price' => 140,
        'category' => 'wallet',
      ],
      [
        'name' => 'Leather Card Holder',
        'description' => 'Minimal leather card holder with a compact design for cards and cash on the go.',
        'image' => 'assets/img/10.jpg',
        'price' => 160,
        'category' => 'wallet',
      ],
      [
        'name' => 'Leather Diary / Folder Cover',
        'description' => 'Premium leather diary cover with a clean, professional design for everyday use.',
        'image' => 'assets/img/P2.jpg',
        'price' => 130,
        'category' => 'office accessories',
      ],
      [
        'name' => 'Leather Long Wallet (Black)',
        'description' => 'Luxury black leather long wallet with multiple compartments and zip sections for organized storage.',
        'image' => 'assets/img/8.jpg',
        'price' => 150,
        'category' => 'wallet',
      ],
      [
        'name' => 'Croc Embossed Tote Bag',
        'description' => 'Elegant croc-embossed tote crafted for everyday luxury.',
        'image' => 'assets/img/bag 2.jpg',
        'price' => 240,
        'category' => 'office accessories',
      ],
      [
        'name' => 'Leather Office Laptop Tote',
        'description' => 'Premium leather tote with spacious pockets for work essentials.',
        'image' => 'assets/img/bag 1.jpg',
        'price' => 299,
        'category' => 'office accessories',
      ],
      [
        'name' => 'Leather Briefcase / Document Bag',
        'description' => 'Sleek zip briefcase designed for meetings and daily travel.',
        'image' => 'assets/img/LL.jpg',
        'price' => 260,
        'category' => 'office accessories',
      ],
      [
        'name' => 'Leather Travel Organizer Roll',
        'description' => 'Classic leather roll organizer for travel and essentials.',
        'image' => 'assets/img/bag4.jpg',
        'price' => 270,
        'category' => 'office accessories',
      ],
    ];

    foreach ($items as $p) {
      Product::updateOrCreate(
        ['slug' => Str::slug($p['name'])],
        [
          'name' => $p['name'],
          'slug' => Str::slug($p['name']),
          'description' => $p['description'],
          'image' => $p['image'],
          'price' => $p['price'],
          'currency' => 'USD',
          'category' => $p['category'],
          'is_active' => true,
        ]
      );
    }
  }
}
