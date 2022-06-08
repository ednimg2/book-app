<?php

namespace App\Services\Import\NewYorkTime;

use App\Models\Book;

class BookFactory
{
    public function create(array $data): Book
    {
        $bookEntity = new Book();
        $bookEntity->name = isset($book['title']) ? $book['title'] : null;
        $bookEntity->description = $book['description'] ?? null;
        $bookEntity->iban = $book['primary_isbn10'] ?? null;
        $bookEntity->sku = uniqid();

        return $bookEntity;
    }
}
