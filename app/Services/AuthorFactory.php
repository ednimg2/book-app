<?php

namespace App\Services;

use App\Models\Author;

class AuthorFactory
{
    public function create(string $author): Author
    {
        $authorEntity = new Author();
        $authorEntity->first_name = trim($author);

        return $authorEntity;
    }
}
