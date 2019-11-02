<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Repository;

use ShoppingCart\Domain\Model\Product;

interface WarehouseRepository
{
    public function hasNotEnough(Product $product, int $quantity): bool;
}
