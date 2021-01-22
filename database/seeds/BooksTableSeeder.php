<?php

use Illuminate\Database\Seeder;
use App\Book;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::create([
            'title' => 'Belajar Pemrograman Java',
            'slug' => Str::slug('Belajar Pemrograman Java'),
            'description' => 'Buku Pertama Belajar Pemrograman Java Untuk Pemula.',
            'author' => 'Abdul Kadir',
            'publisher' => 'PT. Restu Ibu',
            'cover' => 'buku_java.jpg',
            'price' => 55000,
            'stock' => 20,
            'created_by' => 1,
        ])->categories()->attach(['3', '6']);

        Book::create([
            'title' => 'Pemrograman Android',
            'slug' => Str::slug('Pemrograman Android'),
            'description' => 'Jurus Rahasia Menguasai Pemrograman Android.',
            'author' => 'Muhammad Nurhidayat',
            'publisher' => 'PT. Restu Guru',
            'cover' => 'urus_rahasia.jpg',
            'price' => 70000,
            'stock' => 24,
            'created_by' => 1,
        ])->categories()->attach(['1', '2', '3', '5']);
        
        Book::create([
            'title' => 'Android Application',
            'slug' => Str::slug('Android Application'),
            'description' => 'Buku Pertama Belajar Pemrograman Java Untuk Pemula.',
            'author' => 'Dina Aulia',
            'publisher' => 'PT. Restu Guru',
            'cover' => 'create_your.jpg',
            'price' => 45000,
            'stock' => 7,
            'created_by' => 1,
        ])->categories()->attach(['1', '3', '9']);
    }
}
