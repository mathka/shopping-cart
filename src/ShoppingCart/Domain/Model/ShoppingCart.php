<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

interface ShoppingCart
{
    //TODO this is inconsistent (Product && quantity v. Item)...
    public function addItem(Product $product, int $quantity): void;

    public function removeItem(Item $item): void;

    public function getItemList(): ItemList;
}
