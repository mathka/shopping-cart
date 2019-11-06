<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Repository;

use ShoppingCart\Domain\Model\Product;

interface WarehouseRepository
{
    public function isNotEnough(Product $product, int $quantity): bool;
}
