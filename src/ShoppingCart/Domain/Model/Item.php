<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

interface Item
{
    public function getProduct(): Product;

    public function getQuantity(): int;
}
