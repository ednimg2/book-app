<?php

namespace Tests\Unit;

use App\Services\Import\NewYorkTime\AuthorsCountParser;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    private AuthorsCountParser $parser;

    protected function setUp(): void
    {
        //Kas turi būti padaryta prieš kiekvieną test vykdymo methodą.
        $this->parser = new AuthorsCountParser();
    }

    /**
     *
     * 0. null
     * 4. 'asdfsadfasadfasdf,fsadsadfasdfas 345234'
     * 1. 'Jonh',
     * 2. 'Jonh and Somethin',
     * 3. 'Jonh, Tom and Somethin',
     */
    public function testCatchException()
    {
        //tikimės
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Authors name should be only simple string');

        //vykdomas kodas
        $this->parser->parse('Nevalidus 123123123, 123123123');

//        try {
//              $this->parser->parse('Nevalidus 123123123, 123123123');
//        } catch (\Throwable $exception) {
//            $this->assertEquals(\InvalidArgumentException::class, get_class($exception));
//            $this->assertEquals('Authors name should be only simple string', $exception->getMessage());
//        }
    }

    /**
     * @dataProvider dataset
     */
    public function testIfParseWell(?string $author, array $result)
    {
        $data = $this->parser->parse($author);

        $this->assertEquals($result, $data);
    }

    public function dataset(): array
    {
        return [
            'test if parse null' => [
                'authoerString' => null,
                'result' => []
            ],
            'test one item' => [
                'authorsString' => 'John Testing',
                'result' => ['John Testing'],
            ],
            'test John case' => [
                'authorsString' => 'John',
                'result' => ['John Deere'],
            ],
            'test Tom case' => [
                'authorsString' => 'Tom',
                'result' => ['Tom', 'Jerry'],
            ],
            'test two items with delimeter ,' => [
                'authorsString' => 'Tom, Failed',
                'result' => ['Tom', 'Failed'],
            ],
            'test three items with delimeter ,' => [
                'authorsString' => 'Tom, John, Something',
                'result' => ['Tom', 'John', 'Something'],
            ],
            'test two items with and delimiter' => [
                'authorString' => 'Tom and John',
                'result' => ['Tom', 'John']
            ],
            'test three items with dilimiters: "," "and"' => [
                'authorString' => 'Jonh, Tom and Somethin',
                'result' => ['Jonh', 'Tom', 'Somethin'],
            ]
        ];
    }
}
