<?php

namespace Tests\Unit;

use App\Models\Author;
use App\Services\AuthorFactory;
use App\Services\TDDParser;
use PHPUnit\Framework\TestCase;

class TDDExmapleTest extends TestCase
{
    //1. Is autoriu eilutes sukurti atksirus autoriu instancus, autoriai ailuteje skiriami, kableliais , skirikliais "ir" "&"

    private TDDParser $parser;

    protected function setUp(): void
    {
        $this->parser = new TDDParser(new AuthorFactory());
    }

    public function testIfParseWell()
    {
        $data = 'John';

        $result = new Author();
        $result->first_name = 'John';

        //
        $parserResult = $this->parser->execute($data);
        //

        $this->assertTrue($parserResult instanceof Author);
        $this->assertEquals('John', $parserResult->first_name);
    }

    public function testIfParseWell2Options()
    {
        $data = 'John, Tom';

        $result = new Author();
        $result->first_name = 'John';

        $result2 = new Author();
        $result2->first_name = 'Tom';

        //
        $parserResult = $this->parser->execute($data);
        //

        $this->assertIsArray($parserResult);
        $this->assertEquals('John', $parserResult[0]->first_name);
        $this->assertEquals('Tom', $parserResult[1]->first_name);
    }

    public function testIfParseWell3Options()
    {
        $data = 'John, Tom & Kamuolys';

        $result = new Author();
        $result->first_name = 'John';

        $result2 = new Author();
        $result2->first_name = 'Tom';

        $result3 = new Author();
        $result3->first_name = 'Kamuolys';

        //
        $parserResult = $this->parser->execute($data);
        //

        $this->assertIsArray($parserResult);
        $this->assertEquals('John', $parserResult[0]->first_name);
        $this->assertEquals('Tom', $parserResult[1]->first_name);
        $this->assertEquals('Kamuolys', $parserResult[2]->first_name);
    }

    public function testIfParseWell4Options()
    {
        $data = 'John, Tom & Kamuolys ir Papildomas';

        $result = new Author();
        $result->first_name = 'John';

        $result2 = new Author();
        $result2->first_name = 'Tom';

        $result3 = new Author();
        $result3->first_name = 'Kamuolys';

        $result4 = new Author();
        $result4->first_name = 'Papildomas';
        //
        $parserResult = $this->parser->execute($data);
        //

        $this->assertIsArray($parserResult);
        $this->assertEquals('John', $parserResult[0]->first_name);
        $this->assertEquals('Tom', $parserResult[1]->first_name);
        $this->assertEquals('Kamuolys', $parserResult[2]->first_name);
        $this->assertEquals('Papildomas', $parserResult[3]->first_name);
    }

    public function testIfParseWell5Options()
    {
        $data = 'John, Tom & Kamuolys ir Papildomas ir Irmantas';

        $result = new Author();
        $result->first_name = 'John';

        $result2 = new Author();
        $result2->first_name = 'Tom';

        $result3 = new Author();
        $result3->first_name = 'Kamuolys';

        $result4 = new Author();
        $result4->first_name = 'Papildomas';

        $result5 = new Author();
        $result5->first_name = 'Irmantas';
        //
        $parserResult = $this->parser->execute($data);
        //

        $this->assertIsArray($parserResult);
        $this->assertEquals('John', $parserResult[0]->first_name);
        $this->assertEquals('Tom', $parserResult[1]->first_name);
        $this->assertEquals('Kamuolys', $parserResult[2]->first_name);
        $this->assertEquals('Papildomas', $parserResult[3]->first_name);
        $this->assertEquals('Irmantas', $parserResult[4]->first_name);
    }

    public function testIfParseWell5irOptions()
    {
        $data = 'John, Tom & Kamuolys ir Papildomas ir irmantas';

        $result = new Author();
        $result->first_name = 'John';

        $result2 = new Author();
        $result2->first_name = 'Tom';

        $result3 = new Author();
        $result3->first_name = 'Kamuolys';

        $result4 = new Author();
        $result4->first_name = 'Papildomas';

        $result5 = new Author();
        $result5->first_name = 'Irmantas';
        //
        $parserResult = $this->parser->execute($data);
        //

        $this->assertIsArray($parserResult);
        $this->assertEquals('John', $parserResult[0]->first_name);
        $this->assertEquals('Tom', $parserResult[1]->first_name);
        $this->assertEquals('Kamuolys', $parserResult[2]->first_name);
        $this->assertEquals('Papildomas', $parserResult[3]->first_name);
        $this->assertEquals('irmantas', $parserResult[4]->first_name);
    }

    public function testEmpty()
    {
        $data = '';

        $parserResult = $this->parser->execute($data);
        //

        $this->assertEquals([], $parserResult);
    }

    public function testNull()
    {
        $data = null;

        $parserResult = $this->parser->execute($data);
        //

        $this->assertEquals([], $parserResult);
    }
}
