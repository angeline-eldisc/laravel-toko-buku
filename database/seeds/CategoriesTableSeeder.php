<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Android Studio',
            'slug' => Str::slug('Android Studio'),
            'image' => 'android-studio.png',
            'created_by' => 1
        ]);

        Category::create([
            'name' => 'Android',
            'slug' => Str::slug('Android'),
            'image' => 'android.png',
            'created_by' => 1
        ]);

        Category::create([
            'name' => 'Computer Programming',
            'slug' => Str::slug('Computer Programming'),
            'image' => 'computer-programming.jpeg',
            'created_by' => 1
        ]);

        Category::create([
            'name' => 'Fashion Design',
            'slug' => Str::slug('Fashion Design'),
            'image' => 'fashion-design.jpg',
            'created_by' => 1
        ]);

        Category::create([
            'name' => 'Helpful Tips',
            'slug' => Str::slug('Helpful Tips'),
            'image' => 'helpful-tips.jpg',
            'created_by' => 1
        ]);

        Category::create([
            'name' => 'Java',
            'slug' => Str::slug('Java'),
            'image' => 'java.png',
            'created_by' => 1
        ]);

        Category::create([
            'name' => 'PHP',
            'slug' => Str::slug('PHP'),
            'image' => 'php.png',
            'created_by' => 1
        ]);

        Category::create([
            'name' => 'Sports',
            'slug' => Str::slug('Sports'),
            'image' => 'sports.jpg',
            'created_by' => 1
        ]);

        Category::create([
            'name' => 'Technology Design',
            'slug' => Str::slug('Technology Design'),
            'image' => 'technology-design.png',
            'created_by' => 1
        ]);
    }
}
