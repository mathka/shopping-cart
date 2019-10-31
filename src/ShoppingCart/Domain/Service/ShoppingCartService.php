<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Service;

use ShoppingCart\Domain\Model\Product;

interface ShoppingCartService
{
    public function addProduct(Product $product, int $quantity);
}
