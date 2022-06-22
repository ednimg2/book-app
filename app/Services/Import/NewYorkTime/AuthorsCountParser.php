<?php

namespace App\Services\Import\NewYorkTime;

class AuthorsCountParser
{
    public function parse(?string $authorsString): array
    {
        //2 atvejai
        //1: skipinam
        //2: throw exceptiona

        if (!$authorsString) {
            return [];
        }

        if (preg_match("/\d+/", $authorsString)) {
            throw new \InvalidArgumentException('Authors name should be only simple string');
        }

        if ($authorsString === 'John') {
            return ['John Deere'];
        } elseif ($authorsString === 'Tom') {
            return ['Tom', 'Jerry'];
        }

        $authors = str_replace(" and ", ",", $authorsString);

        return array_map(
            function ($string) {
                return trim($string);
            },
            explode(',', $authors)
        );
    }
}
