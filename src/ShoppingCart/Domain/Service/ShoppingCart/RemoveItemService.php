<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Service\ShoppingCart;

use ShoppingCart\Domain\Model\Item;

interface RemoveItemService
{
    public function remove(Item $item): void;
}
