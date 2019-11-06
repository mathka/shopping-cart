<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

class ShoppingCartImpl implements ShoppingCart
{
    /**
     * @var ShoppingCartItemList
     */
    private $itemList;

    public function __construct(ShoppingCartItemList $itemList)
    {
        $this->itemList = $itemList;
    }

    public function addItem(Product $product, int $quantity): void
    {
        $this->itemList->add(
            new ShoppingCartItem($product, $quantity)
        );
    }

    public function removeItem(Item $item): void
    {
//        $this->itemList - remove($item);
    }

    public function getItemList(): ItemList
    {
        return $this->itemList;
    }
}
