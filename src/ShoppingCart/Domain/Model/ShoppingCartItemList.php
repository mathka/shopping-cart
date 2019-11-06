<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

//Może to powinna być abstrakcja - lista produktów?...
class ShoppingCartItemList implements ItemList
{
    /**
     * @var Item[]
     */
    private $items = [];

    public function add(Item $item): void
    {
//        $key = $item->getId();
//        $this->items[$key] = $item;
        $this->items[] = $item;
    }

    public function remove(Item $item): void
    {
        // TODO: Implement remove() method.
        //$criteria['status'] = \array_filter($criteria['status'], function ($status) {
        //                return $status !== ResourceStatusType::DELETED;
        //            });
    }

    /**
     * {@inheritdoc}
     */
    public function getList(): array
    {
        return $this->items;
    }

    private function find(Item $item): ?Item
    {
        $key = $item->getId();
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }

        return null;
    }
}
