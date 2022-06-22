<?php

namespace App\DTO;

class Basket
{
    /** @var iterable|array|BasketItem[]  */
    private iterable $items;

    private int $totalPrice;

    public function __construct()
    {
        $this->items = [];
        $this->totalPrice = 0;
    }

    public function setTotalPrice(int $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    public function setItems(iterable $items): void
    {
        $this->items = $items;
    }

    public function getItem(int $productId): BasketItem
    {
        return $this->items[$productId];
    }

    public function hasItem(int $productId): bool
    {
        return isset($this->items[$productId]);
    }

    public function addItem(BasketItem $item): void
    {
        $this->items[$item->getProductId()] = $item;
    }

    public function removeItem(int $productId): void
    {
        if ($this->hasItem($productId)) {
            unset($this->items[$productId]);
        }
    }

    /**
     * @return iterable|BasketItem[]|array
     */
    public function getItems(): iterable
    {
        return $this->items;
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }
}
