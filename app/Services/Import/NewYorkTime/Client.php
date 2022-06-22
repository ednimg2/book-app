<?php

namespace App\Services\Import\NewYorkTime;

class Client implements ClientInterface
{
    private string $secret;

    /**
     * @param string $secret
     */
    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function getData(): array
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request(
            'GET',
            'https://api.nytimes.com/svc/books/v3/lists/current/hardcover-fiction.json?api-key=' . $this->secret
        );

        if ($res->getStatusCode() !== 200) {
            throw new \Exception('Invalid client code');
        }

        return json_decode($res->getBody(), true);
    }
}
