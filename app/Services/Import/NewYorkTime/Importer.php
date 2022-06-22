<?php

namespace App\Services\Import\NewYorkTime;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Repository\BookRepository;
use App\Services\Import\ImportStrategy;

class Importer implements ImportStrategy
{
    private ClientInterface $client;
    private AuthorsCountParser $authorsCountParser;
    private BookRepository $repository;
    private BookFactory $bookFactory;

    /**
     * @param ClientInterface $client
     */
    public function __construct(
        ClientInterface $client,
        AuthorsCountParser $authorsCountParser,
        BookRepository $repository,
        BookFactory $bookFactory
    ) {
        $this->bookFactory = $bookFactory;
        $this->repository = $repository;
        $this->authorsCountParser = $authorsCountParser;
        $this->client = $client;
    }

    public function support(string $type): bool
    {
        return $type === 'nyt';
    }

    public function import(): array
    {
        $data = $this->client->getData();
        $books = [];

        if (isset($data['status']) && $data['status'] === "OK" && isset($data['num_results']) && $data['num_results'] > 0) {
//            $category = new Category();
//            $category->name = $data['results']['list_name'];
//            $category->active = true;
//            $category->save();

            foreach ($data['results']['books'] as $book) {
                $bookEntity = $this->bookFactory->create($book);
//                $bookEntity->category_id = $category->id;
                $this->repository->save($bookEntity);
                $books[] = $bookEntity;

                $authorsArray = $this->authorsCountParser->parse($book['author'] ?? null);

//                $authors = str_replace(" and ", ",", $book['author']);
//                $authorsArray = explode(',', $authors);
//
//                foreach ($authorsArray as $author) {
//                    $authorEntity = new Author();
//                    $authorEntity->first_name = $author;
//                    $authorEntity->last_name = "";
//                    $authorEntity->save();
//                    $bookEntity->authors()->attach($authorEntity);
//                    $bookEntity->save();
//                }
            }
        }

        return $books;
    }
}
