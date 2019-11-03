<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

class ShoppingCartImpl implements ShoppingCart
{
    /**
     * @var ItemList
     */
    private $itemList;

    public function __construct(ItemList $itemList)
    {
        $this->itemList = $itemList;
    }

    public function addItem(Product $product, int $quantity): void
    {
        $this->itemList->add($product, $quantity);
    }
}
