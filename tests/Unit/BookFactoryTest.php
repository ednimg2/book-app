<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Services\Import\NewYorkTime\BookFactory;
use PHPUnit\Framework\TestCase;

class BookFactoryTest extends TestCase
{
    /** @dataProvider dataset */
    public function testIfCreateBook(array $data, Book $result)
    {
        $factory = new BookFactory();

        $book = $factory->create($data);

        $this->assertEquals($result->name, $book->name);
        $this->assertEquals($result->description, $book->description);
        $this->assertEquals($result->iban, $book->iban);
        $this->assertNotNull($book->sku);
    }

    public function dataset(): array
    {
        $book = new Book();
        $book->name = null;
        $book->description = null;
        $book->iban = null;
        $book->sku = "kazkas";

        $book2 = new Book();
        $book2->name = 'Musu title';
        $book2->description = 'Musu descripion';
        $book2->sku = 'kazkoks2';

        return [
            'empty array' => [
                'data' => [],
                'result' => $book
            ],
            'valid data' => [
                'data' => [
                    'title' => 'Musu title',
                    'description' => 'Musu descripion'
                ],
                'result' => $book2
            ]
        ];
    }
}
