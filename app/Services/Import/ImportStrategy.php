<?php

namespace App\Services\Import;

interface ImportStrategy
{
    public function import(): array;

    public function support(string $type): bool;
}
