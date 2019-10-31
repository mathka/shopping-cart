<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

interface ShoppingCart
{
    public function addProduct(Product $product, $quantity);
}
