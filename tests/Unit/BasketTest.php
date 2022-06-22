<?php

namespace Tests\Unit;

use App\DTO\Basket;
use App\DTO\BasketItem;
use App\Models\Auction;
use App\Services\Basket\BasketManager;
use App\Services\Basket\BasketSessionStorage;
use PHPUnit\Framework\TestCase;

class BasketTest extends TestCase
{
    public function testIfAddItem()
    {
        $storageMock = $this->createMock(BasketSessionStorage::class);
        $basketItem = new BasketItem(1, 'Test auction', 5, 2);
        $basket = new Basket();
        $basket->setItems([ 1 => $basketItem]);

        $storageMock
            ->method('get')
            ->willReturn($basket);

        $storageMock
            ->method('store')
            ->with($this->callback(function (Basket $basket) {
                $this->assertEquals(8, $basket->getItem(1)->getQuantity());
                $this->assertEquals(40, $basket->getTotalPrice());

                return true;
            }));

        $manager = new BasketManager($storageMock);
        $auction = new Auction();
        $auction->id = 1;
        $manager->addItem($auction, 6);
    }
}
