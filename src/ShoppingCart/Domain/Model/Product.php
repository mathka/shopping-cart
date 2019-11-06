<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

abstract class Product
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Money
     */
    private $price;

    abstract public function lessThanMinimumOrderQuantity(int $quantity): bool;
}
