<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'isbn' => '978-0-7475-3269-9',
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'author' => 'J.K. Rowling',
                'publisher' => 'Bloomsbury',
                'image' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1170803558l/72193.jpg',
                'shelf_number' => 'A1-001',
                'category' => 'Fantasy',
                'stock' => 10,
                'description' => 'The first book in the Harry Potter series, following the young wizard Harry Potter.',
                'language' => 'English',
                'published_date' => '1997-06-26',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'isbn' => '978-0-06-112008-4',
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'publisher' => 'HarperCollins',
                'image' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1553383690l/2657.jpg',
                'shelf_number' => 'B2-002',
                'category' => 'Fiction',
                'stock' => 8,
                'description' => 'A novel about racial injustice and childhood innocence in the American South.',
                'language' => 'English',
                'published_date' => '1960-07-11',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'isbn' => '978-0-14-044913-6',
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'publisher' => 'Penguin Classics',
                'image' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1320399351l/1885.jpg',
                'shelf_number' => 'D4-004',
                'category' => 'Romance',
                'stock' => 15,
                'description' => 'A romantic novel about manners, upbringing, morality, education, and marriage.',
                'language' => 'English',
                'published_date' => '1813-01-28',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'isbn' => '978-0-7432-7356-5',
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'publisher' => 'Scribner',
                'image' => 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1490528560l/4671.jpg',
                'shelf_number' => 'E5-005',
                'category' => 'Fiction',
                'stock' => 9,
                'description' => 'A novel about the American Dream and the Jazz Age.',
                'language' => 'English',
                'published_date' => '1925-04-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
