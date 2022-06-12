<?php

namespace App\Services\Import\NewYorkTime;

class CurrentTimeFormatter
{
    private Clock $clock;

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;
    }

    public function getTime(): string
    {
        $now = $this->clock->getCurrentDateTime();

        if ($now > new \DateTime('2022-06-15')) {
            return $now->format('Y-m-d H:i');
        }

        return $now->format('m.d.Y H:i');
    }
}
