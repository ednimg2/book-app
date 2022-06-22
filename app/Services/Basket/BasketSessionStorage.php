<?php

namespace App\Services\Basket;

use App\DTO\Basket;
use Illuminate\Support\Facades\Session;

class BasketSessionStorage
{
    public function get(): ?Basket
    {
        return Session::get('basket');
    }

    public function store(Basket $basket): void
    {
        Session::put('basket', $basket);
    }

    public function clear(): void
    {
        Session::remove('basket');
    }
}
