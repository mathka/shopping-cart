<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Service\ShoppingCart;

use ShoppingCart\Domain\Exception\ShoppingCartException;
use ShoppingCart\Domain\Model\Product;
use ShoppingCart\Domain\Model\ShoppingCart;

class AddItemServiceImpl implements AddItemService
{
    /**
     * @var ShoppingCart
     */
    private $shoppingCart;

    public function __construct(ShoppingCart $shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }

    public function add(Product $product, int $quantity): void
    {
        if ($product->hasLargerMinimumOrderQuantity($quantity)) {
            throw ShoppingCartException::lessThanMinimumOrderQuantity();
        }

        $this->shoppingCart->addItem($product, $quantity);
    }
}
