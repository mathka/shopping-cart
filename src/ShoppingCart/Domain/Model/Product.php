<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

interface Product
{
    public function hasLargerMinimumOrderQuantity(int $quantity): bool;
}
