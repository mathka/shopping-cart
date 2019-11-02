<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Service\ShoppingCart;

use ShoppingCart\Domain\Model\Product;

interface AddItemService
{
    public function add(Product $product, int $quantity): void;
}
