<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SeoPage;

class SeoPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        $pages = [
            ['key' => 'home', 'name' => 'Home'],

            ['key' => 'categories', 'name' => 'Categories Page'],
            ['key' => 'occasions', 'name' => 'Occasions Page'],

            ['key' => 'cart', 'name' => 'Cart Page'],
            ['key' => 'checkout', 'name' => 'Checkout Page'],

            ['key' => 'about', 'name' => 'About Us'],
            ['key' => 'why_choose_us', 'name' => 'Why Choose Us'],
            ['key' => 'contact', 'name' => 'Contact Us'],
            ['key' => 'bulk_enquiry', 'name' => 'Bulk Enquiry'],

            ['key' => 'blog', 'name' => 'Blog Listing Page'],
            ['key' => 'faq', 'name' => 'FAQ Page'],
        ];

        foreach ($pages as $p) {
            SeoPage::updateOrCreate(
                ['page_key' => $p['key']],
                ['page_name' => $p['name']]
            );
        }
    }
}
