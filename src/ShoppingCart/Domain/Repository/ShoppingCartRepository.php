<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Repository;

use ShoppingCart\Domain\Model\ShoppingCart;

interface ShoppingCartRepository
{
    public function getShoppingCart(): ShoppingCart;
}
