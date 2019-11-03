<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

interface ShoppingCart
{
    public function addItem(Product $product, int $quantity): void;

    public function removeItem(Product $product): void;
}
