<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

class ShoppingCartItem implements Item
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }
}
