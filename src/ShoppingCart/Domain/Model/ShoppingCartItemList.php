<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

class ShoppingCartItemList implements ItemList
{
    /**
     * @var Item[]
     */
    private $items = [];

    public function add(Item $item): void
    {
        $this->items[] = $item;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(): array
    {
        return $this->items;
    }
}
