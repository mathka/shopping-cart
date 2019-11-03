<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Service\ShoppingCart;

use ShoppingCart\Domain\Model\Product;

interface RemoveItemService
{
    public function remove(Product $product): void;
}
