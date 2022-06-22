<?php

namespace Tests\Mock;

use App\Services\Import\NewYorkTime\ClientInterface;

class NewYorkTimeClientMock implements ClientInterface
{
    private array $data = [];

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
