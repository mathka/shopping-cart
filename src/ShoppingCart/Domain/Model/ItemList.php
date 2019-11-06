<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

interface ItemList
{
    public function add(Item $item): void;

    public function remove(Item $item): void;

    /**
     * @return Item[]
     */
    public function getList(): array;
}
