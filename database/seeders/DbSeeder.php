<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
use App\Models\Purchase;

class DbSeeder extends Seeder
{
    
    private const BOOK_COUNT        = 30;
    private const AUTHOR_COUNT      = 20;
    private const BOOK_WITH_AUTHORS = 24;
    private const MAX_AUTHORS       = 4;
    private const MAX_PURCHASES     = 27;
    

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $authors = Author::factory(self::AUTHOR_COUNT)->create();        
        
        for ($x = 0; $x < self::BOOK_COUNT; $x++) {
            Book::factory(1)
                ->has(Purchase::factory(rand(1, self::MAX_PURCHASES)))
                ->create();
        }

        Book::all()->random(self::BOOK_WITH_AUTHORS)->each( function ($book) use ($authors) {
            $book->authors()->attach(
                $authors->random(rand(1, self::MAX_AUTHORS))->pluck('id')->toArray()
            );
        });


    }
}
