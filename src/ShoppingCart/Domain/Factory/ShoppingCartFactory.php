<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Factory;

use ShoppingCart\Domain\Model\ShoppingCart;

interface ShoppingCartFactory
{
    public function create(): ShoppingCart;
}
