<?php

namespace Database\Seeders;

use App\Models\PostType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postTypes = PostType::seedData();
        foreach ($postTypes as $postType) {
            $postType['slug'] = Str::slug($postType['name']);
            PostType::firstOrCreate(
                ['id' => $postType['id']], $postType
            );
        }
    }
}
