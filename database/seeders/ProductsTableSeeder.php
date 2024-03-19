<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Hamkke Korean Class for Beginners',
                'description' => 'Learn how to read, write, and speak Korean at a basic level through our class for beginners.
                    Our skilled Korean-speaking tutors are ready to take you through the journey from absolute novice to learned beginner.
                    Purchase our course and improve your Korean today!',
                'price_in_naira' => 25000,
                'price_in_cents' => null,
                'product_image' => asset('frontend-assets/product-images/hamkke-korean-class-for-beginners.jpeg'),
                'product_category_id' => 1
            ],
            [
                'name' => 'Simplified Korean Study Notes for Beginners',
                'description' => 'Learn how to read and write the names of different animals in Korean easily with these downloadable, self-study worksheets.',
                'price_in_naira' => 1000,
                'product_image' => asset('frontend-assets/product-images/simplified-korean-study-notes-for-beginners.jpeg'),
                'product_category_id' => 1
            ],
            [
                'name' => 'Printable Korean Noun Worksheets (ANIMALS PACK).',
                'description' => 'It covers topics from the Korean Alphabet to introducing yourself and writing short descriptive essays in Korean.
                    Download the PDF to begin your Korean learning journey in the easiest way possible!',
                'price_in_naira' => 1200,
                'product_image' => asset('frontend-assets/product-images/printable-korean-noun-worksheets.jpeg'),
                'product_category_id' => 1
            ]
        ];

        foreach ($products as $p) {
            $productSlug = createSlugFromString($p['name']);
            $p['slug'] = $productSlug;
            $p['price'] = $p['price_in_naira'] * 100;
            Product::firstOrCreate(['name' => $p['name']], Arr::only($p, [
                'slug', 'price', 'description', 'product_image', 'product_category_id'
            ]));
        }
    }
}
