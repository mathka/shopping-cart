<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Factory;

use ShoppingCart\Domain\Model\ShoppingCart;
use ShoppingCart\Domain\Model\ShoppingCartImpl;
use ShoppingCart\Domain\Model\ShoppingCartItemList;

class ShoppingCartFactoryImpl implements ShoppingCartFactory
{
    public function create(): ShoppingCart
    {
        return new ShoppingCartImpl(
            new ShoppingCartItemList()
        );
    }
}
