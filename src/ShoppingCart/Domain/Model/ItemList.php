<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

interface ItemList
{
    public function add(Product $product, int $quantity): void;
}
