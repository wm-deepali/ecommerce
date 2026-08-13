<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Collection;
use Illuminate\Support\Str;

class CollectionSeeder extends Seeder
{
    public function run(): void
    {
        $collections = [
            [
                'code' => 'new_arrival',
                'name' => 'New Arrival',
                'sort_order' => 1,
            ],
            [
                'code' => 'best_seller',
                'name' => 'Best Sellers',
                'sort_order' => 2,
            ],
            [
                'code' => 'premium_collection',
                'name' => 'Premium Collection',
                'sort_order' => 3,
            ],
            [
                'code' => 'exclusive_collection',
                'name' => 'Exclusive Collection',
                'sort_order' => 4,
            ],
        ];

        foreach ($collections as $collection) {

            Collection::updateOrCreate(
                [
                    'code' => $collection['code']
                ],
                [
                    'name'       => $collection['name'],
                    'slug'       => Str::slug($collection['name']),
                    'code'       => $collection['code'],
                    'status'     => 1,
                    'sort_order' => $collection['sort_order'],
                ]
            );
        }
    }
}