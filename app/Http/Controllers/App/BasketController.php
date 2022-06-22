<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Services\Basket\BasketManager;
use Illuminate\Support\Facades\Session;

class BasketController extends Controller
{
    private BasketManager $basketManager;

    public function __construct(BasketManager $basketManager)
    {
        $this->basketManager = $basketManager;
    }

    public function addItem(): string
    {
//        $this->basketManager->addItem(Auction::find(2));
//        $this->basketManager->removeItem(1);
        $this->basketManager->changeQuantity(2, 1);

        var_dump($this->basketManager->getBasket());
        var_dump($this->basketManager->getBasket()->getTotalPrice());


        return 'testingBasket';
    }
}
