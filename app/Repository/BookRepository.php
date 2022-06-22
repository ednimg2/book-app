<?php

namespace App\Repository;

use App\Models\Book;

class BookRepository
{
    public function save(Book $book): bool
    {
        return $book->save();
    }

    public function findAll()
    {
        return Book::all();
    }
}
