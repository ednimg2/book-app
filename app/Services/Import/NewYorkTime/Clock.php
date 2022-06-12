<?php

namespace App\Services\Import\NewYorkTime;

use DateTime;

class Clock
{
    public function getCurrentDateTime(): DateTime
    {
        return new DateTime();
    }
}
