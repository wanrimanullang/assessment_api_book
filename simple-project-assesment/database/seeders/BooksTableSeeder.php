<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

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
            'title' => 'Sample Book 1',
            'author' => 'Author 1',
            'published_year' => 2022,
        ]);

        Book::create([
            'title' => 'Sample Book 2',
            'author' => 'Author 2',
            'published_year' => 2020,
        ]);

    }
}
