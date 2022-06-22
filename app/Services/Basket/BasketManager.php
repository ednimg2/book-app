<?php

namespace App\Services\Basket;

use App\DTO\Basket;
use App\DTO\BasketItem;
use App\Models\Auction;

class BasketManager
{
    private BasketSessionStorage $basketSessionStorage;

    public function __construct(BasketSessionStorage $basketSessionStorage)
    {
        $this->basketSessionStorage = $basketSessionStorage;
    }

    public function addItem(Auction $auction, int $quantity = 1): void
    {
        $basket = $this->getBasket();

        if ($basket->hasItem($auction->id)) {
            $basketItem = $basket->getItem($auction->id);
            $basketItem->setQuantity($basketItem->getQuantity() + $quantity);
        } else {
            $basketItem = new BasketItem(
                $auction->id,
                $auction->book->name,
                $auction->price,
                $quantity
            );

            $basket->addItem($basketItem);
        }

        $this->recalculate();

        //Jeigu būčiau sylius saugočiau į DB
        $this->basketSessionStorage->store($basket);
//        Session::put('basket', $basket);

    }

    public function removeItem(int $productId): void
    {
        $basket = $this->getBasket();

        if ($basket->hasItem($productId)) {
            $basket->removeItem($productId);
            $this->recalculate();
//            Session::put('basket', $basket);
            $this->basketSessionStorage->store($basket);
        }
//        else {
//            throw new \InvalidArgumentException('Invalid product id Provided');
//        }
        // else jei norim galim mesti exception
    }

    public function changeQuantity(int $productId, int $quantity): void
    {
        $basket = $this->getBasket();

        if ($basket->hasItem($productId)) {
            $basketItem = $basket->getItem($productId);
            $basketItem->setQuantity($quantity);
            $this->recalculate();
//            Session::put('basket', $basket);
            $this->basketSessionStorage->store($basket);
        }
    }

    public function recalculate(): void
    {
        $basket = $this->getBasket();
        $total = 0;

        foreach ($basket->getItems() as $item) {
            $total += $item->getQuantity() * $item->getUnitPrice();
        }

        //apply discount

        $basket->setTotalPrice($total);
    }

    public function getBasket(): Basket
    {
        //Jeigu būčiau sylius traukčiau iš DB
        $basket = $this->basketSessionStorage->get();
//        Session::get('basket');

        return $basket ?: new Basket();
    }

    public function clear(): void
    {
        //jeigu būčiau sylius trinčiau record iš db
        //Session::remove('basket');
        $this->basketSessionStorage->clear();
    }
}
