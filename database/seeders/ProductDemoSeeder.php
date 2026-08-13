<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\CategoryAttribute;

class ProductDemoSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        $category = Category::create([
            'name' => 'Fabrics',
            'slug' => 'fabrics',
            'status' => 1,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Subcategory
        |--------------------------------------------------------------------------
        */

        $subcategory = Category::create([
            'parent_id' => $category->id,
            'name' => 'Cotton Fabrics',
            'slug' => 'cotton-fabrics',
            'status' => 1,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Fabric Attribute
        |--------------------------------------------------------------------------
        */

        $fabricAttribute = Attribute::create([
            'name' => 'Fabric',
            'slug' => 'fabric',
            'type' => 'select',
            'has_values' => 1,
            'status' => 1,
        ]);

        foreach ([
            'Cotton',
            'Silk',
            'Linen',
            'Polyester'
        ] as $value) {

            AttributeValue::create([
                'attribute_id' => $fabricAttribute->id,
                'value' => $value,
                'status' => 1,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Color Attribute
        |--------------------------------------------------------------------------
        */

        $colorAttribute = Attribute::create([
            'name' => 'Color',
            'slug' => 'color',
            'type' => 'select',
            'has_values' => 1,
            'status' => 1,
        ]);

        foreach ([
            'Red',
            'Blue',
            'Black',
            'White'
        ] as $value) {

            AttributeValue::create([
                'attribute_id' => $colorAttribute->id,
                'value' => $value,
                'status' => 1,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Size Attribute
        |--------------------------------------------------------------------------
        */

        $sizeAttribute = Attribute::create([
            'name' => 'Size',
            'slug' => 'size',
            'type' => 'select',
            'has_values' => 1,
            'status' => 1,
        ]);

        foreach ([
            'S',
            'M',
            'L',
            'XL'
        ] as $value) {

            AttributeValue::create([
                'attribute_id' => $sizeAttribute->id,
                'value' => $value,
                'status' => 1,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Attach To Category
        |--------------------------------------------------------------------------
        */

        CategoryAttribute::create([
            'category_id' => $category->id,
            'attribute_id' => $fabricAttribute->id,

            'is_required' => 1,

            'used_for_variant' => 0,

            'show_in_filter' => 1,
            'show_on_listing' => 1,

            'sort_order' => 1,
            'status' => 1,
        ]);

        CategoryAttribute::create([
            'category_id' => $category->id,
            'attribute_id' => $colorAttribute->id,

            'is_required' => 1,

            'used_for_variant' => 1,

            'show_in_filter' => 1,
            'show_on_listing' => 1,

            'sort_order' => 2,
            'status' => 1,
        ]);

        CategoryAttribute::create([
            'category_id' => $category->id,
            'attribute_id' => $sizeAttribute->id,

            'is_required' => 1,

            'used_for_variant' => 1,

            'show_in_filter' => 1,
            'show_on_listing' => 1,

            'sort_order' => 3,
            'status' => 1,
        ]);
    }
}