<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Service;

use ShoppingCart\Domain\Model\Product;
use ShoppingCart\Domain\Model\ShoppingCart;

class ShoppingCartServiceImpl implements ShoppingCartService
{
    /**
     * @var ShoppingCart
     */
    private $shoppingCart;

    public function __construct(ShoppingCart $shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }

    public function addProduct(Product $product, int $quantity)
    {
        $this->shoppingCart->addProduct($product, $quantity);
    }
}
