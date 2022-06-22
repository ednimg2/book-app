<?php

namespace App\DTO;

class BasketItem
{
//    private $basketId;

    private int $productId;

    private string $title;

    private int $unitPrice;

    private int $quantity;

    public function __construct(
        int $productId,
        string $title,
        int $unitPrice,
        int $quantity
    ) {
        $this->productId = $productId;
        $this->title = $title;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
