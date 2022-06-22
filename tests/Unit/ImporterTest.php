<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Repository\BookRepository;
use App\Services\Import\NewYorkTime\AuthorsCountParser;
use App\Services\Import\NewYorkTime\BookFactory;
use App\Services\Import\NewYorkTime\Importer;
use PHPUnit\Framework\TestCase;
use Tests\Mock\NewYorkTimeClientMock;

class ImporterTest extends TestCase
{
    public function testIfImports()
    {
        $importer = new Importer(
            new NewYorkTimeClientMock(),
            new AuthorsCountParser(),
            new BookRepository(),
            new BookFactory()
        );

        $result = $importer->import();

        $this->assertEquals([], $result);
    }

    /**
     * @dataProvider dataset
     */
    public function testIfHaveOneBook(string $json, array $datasetResult)
    {
        $mock = new NewYorkTimeClientMock();
        $mock->setData(json_decode($json, true));
        $bookRepositoryMock = $this->createMock(BookRepository::class);
        $bookRepositoryMock->method('save')->willReturn(true);
        $importer = new Importer(
            $mock,
            new AuthorsCountParser(),
            $bookRepositoryMock,
            new BookFactory()
        );

        $result = $importer->import();

        $this->assertCount(1, $result);
        $this->assertEquals(1, count($result));
        $book = $result[0];
        $this->assertEquals($datasetResult[0]->name, $book->name);
        $this->assertEquals($datasetResult[0]->description, $book->description);
        $this->assertEquals($datasetResult[0]->iban, $book->iban);
    }

    public function dataset(): array
    {
        $book = new Book();
        $book->description =  "Harry Booth, a master thief, breaks things off with Miranda when a dangerous contact might harm her.";
        $book->name = "Knygos pavadinimas";
        $book->iban = "1250278198";

        $book1 = new Book();

        return [
            'one book with information' => [
                'json' => '
                    {
                      "status": "OK",
                      "num_results": 15,
                      "results": {
                        "books": [
                          {
                            "primary_isbn10": "1250278198",
                            "primary_isbn13": "9781250278197",
                            "description": "Harry Booth, a master thief, breaks things off with Miranda when a dangerous contact might harm her.",
                            "title": "Knygos pavadinimas",
                            "isbns": [
                              {
                                  "isbn10": "1250278198",
                                "isbn13": "9781250278197"
                              },
                              {
                                  "isbn10": "1250278201",
                                "isbn13": "9781250278203"
                              }
                            ]
                          }
                    ],
                    "corrections": []
                    }
                    }',
                'result' => [$book]
            ],
            'one book without information' => [
                'json' => '
                    {
                      "status": "OK",
                      "num_results": 15,
                      "results": {
                        "books": [
                          {
                            "primary_isbn13": "9781250278197",
                            "isbns": [
                              {
                                  "isbn10": "1250278198",
                                "isbn13": "9781250278197"
                              },
                              {
                                  "isbn10": "1250278201",
                                "isbn13": "9781250278203"
                              }
                            ]
                          }
                    ],
                    "corrections": []
                    }
                    }',
                'result' => [$book1]
            ]
        ];
    }
}
