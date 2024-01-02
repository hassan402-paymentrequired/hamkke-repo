<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (PostCategory::seedData() as $postCategory)
        {
            $postCategory['slug'] = Str::slug($postCategory['name']);
            PostCategory::firstOrCreate([
                'id'=> $postCategory['id']
            ], $postCategory);
        }
    }
}
