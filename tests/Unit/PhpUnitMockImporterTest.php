<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Repository\BookRepository;
use App\Services\Import\NewYorkTime\AuthorsCountParser;
use App\Services\Import\NewYorkTime\BookFactory;
use App\Services\Import\NewYorkTime\ClientInterface;
use App\Services\Import\NewYorkTime\Importer;
use PHPUnit\Framework\TestCase;
use Tests\Mock\NewYorkTimeClientMock;

class PhpUnitMockImporterTest extends TestCase
{
//    protected function setUp(): void
//    {
//        file_put_contents('/import/import.csv');
//    }
//
//    protected function tearDown(): void
//    {
//        unlink('/import/import.csv');
//    }

    /**
     * @dataProvider dataset
     */
    public function testIfHaveOneBook(string $json, array $datasetResult)
    {
        $mock = $this->createMock(ClientInterface::class);
        $mock
            ->expects($this->any())
            ->method('getData')
            ->willReturn(json_decode($json, true));

        $mockParser = $this->createMock(AuthorsCountParser::class);
        $mockParser
            ->expects($this->exactly(1))
            ->method('parse')
            ->willReturn([]);

        $mockRepository = $this->createMock(BookRepository::class);
        $mockRepository
            ->expects($this->exactly(1))
            ->method('save');
//            ->with(
//                $this->callback(function (Book $book) use ($datasetResult) {
//                    $this->assertEquals($datasetResult[0]->name, $book->name);
//                    $this->assertEquals($datasetResult[0]->description, $book->description);
//                    $this->assertEquals($datasetResult[0]->iban, $book->iban);
//
//                    return true;
//                })
//            );

        $importer = new Importer($mock, $mockParser, $mockRepository, new BookFactory());

        $result = $importer->import();

//        $this->assertCount(1, $result);
//        $this->assertEquals(1, count($result));
//        $book = $result[0];
//        $this->assertEquals($datasetResult[0]->name, $book->name);
//        $this->assertEquals($datasetResult[0]->description, $book->description);
//        $this->assertEquals($datasetResult[0]->iban, $book->iban);
    }

    public function dataset(): array
    {
        $book = new Book();
        $book->description = "Harry Booth, a master thief, breaks things off with Miranda when a dangerous contact might harm her.";
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
                            "author": "Knygos pavadinimas",
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
                            "author": "Knygos pavadinimas",
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
