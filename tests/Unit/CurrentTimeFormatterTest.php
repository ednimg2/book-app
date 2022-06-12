<?php

namespace Tests\Unit;

use App\Services\Import\NewYorkTime\Clock;
use App\Services\Import\NewYorkTime\CurrentTimeFormatter;
use PHPUnit\Framework\TestCase;

class CurrentTimeFormatterTest extends TestCase
{
    public function testDate()
    {
        $clock = $this->createMock(Clock::class);

        $clock
            ->method('getCurrentDateTime')
            ->willReturn(new \DateTime('2022-01-02 13:13'));

        $formatter = new CurrentTimeFormatter($clock);

        $this->assertEquals('01.02.2022 13:13', $formatter->getTime());
    }

    public function testAfter0615Date()
    {
        $clock = $this->createMock(Clock::class);

        $clock
            ->method('getCurrentDateTime')
            ->willReturn(new \DateTime('2022-09-02 13:13'));

        $formatter = new CurrentTimeFormatter($clock);

        $this->assertEquals('2022-09-02 13:13', $formatter->getTime());
    }
}
