<?php

namespace App\Services;

use App\Models\Author;

class TDDParser
{
    private AuthorFactory $authorFactory;

    public function __construct(AuthorFactory $authorFactory)
    {
        $this->authorFactory = $authorFactory;
    }

    public function execute(?string $authorString)
    {
        if (!$authorString) {
            return [];
        }

        $results = [];
        $authors = explode(',', str_replace(['&', 'ir '], ',', $authorString));

        foreach ($authors as $author) {
            $results[] = $this->authorFactory->create($author);
        }

        if (count($results) === 1) {
            return $results[0];
        }

        return $results;
    }
}
