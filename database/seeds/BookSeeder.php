<?php

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::truncate();
        BookCopy::truncate();

        DB::connection('old')->table('books')
            ->select('books.title', 'books.id as book_id', 'authors.id as author_id', 'book_formats.isbn', 'book_details.description', 'categories.id as category_id', 'publishers.id as publisher_id', 'books.no_of_pages as length', 'book_formats.publication_date as date', 'book_formats.format as format', 'book_type_prices.price as price', 'book_type_prices.status as condition', 'book_type_prices.no_of_stock as quantity', 'book_formats.thumbnail_big as image')
            ->join('author_books', 'author_books.books_id', '=', 'books.id')
            ->join('authors', 'author_books.authors_id', '=', 'authors.id')
            ->join('category_books', 'category_books.books_id', '=', 'books.id')
            ->join('categories', 'category_books.categories_id', '=', 'categories.id')
            ->join('book_formats', 'book_formats.books_id', '=', 'books.id')
            ->join('publisher_books', 'book_formats.id', '=', 'publisher_books.book_formats_id')
            ->join('publishers', 'publishers.id', '=', 'publisher_books.publishers_id')
            ->join('book_details', 'books.id', '=', 'book_details.books_id')
            ->join('book_owners', 'book_owners.books_id', '=', 'books.id')
            ->join('book_type_prices', 'book_type_prices.book_owners_id', '=', 'book_owners.id')
            ->get()
            ->each(function($the_book) {
                $book = Book::create([
                    'name' => $the_book->title, 
                    'author_id' => $the_book->author_id, 
                    'isbn' => $the_book->isbn, 
                    'excerpt' => $the_book->description, 
                    'synopsis' => $the_book->description, 
                    'category_id' => $the_book->category_id, 
                    'publisher_id' => $the_book->publisher_id, 
                    'date' => $the_book->date,
                    'length' => $the_book->length
                ]);

                $copy = $book->copies()->create([
                    'seller_id' => 1, 
                    'type' => $the_book->format, 
                    'price' => $the_book->price, 
                    'condition' => $the_book->condition,
                    'quantity' => $the_book->quantity, 
                    'sold' => 0, 
                    'remainder' => $the_book->quantity, 
                    'image' => "/uploads/books/$the_book->book_id/$the_book->image"
                ]);

                $book->update([
                    'main_copy_id' => $copy->id
                ]);
        });
    }
}
