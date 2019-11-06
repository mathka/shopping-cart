<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Service\ShoppingCart;

use ShoppingCart\Domain\Model\Item;
use ShoppingCart\Domain\Repository\ShoppingCartRepository;

class RemoveItemServiceImpl implements RemoveItemService
{
    /**
     * @var ShoppingCartRepository
     */
    private $shoppingCartRepository;

    public function __construct(ShoppingCartRepository $shoppingCartRepository)
    {
        $this->shoppingCartRepository = $shoppingCartRepository;
    }

    public function remove(Item $item): void
    {
        $shoppingCart = $this->shoppingCartRepository->getShoppingCart();
        $shoppingCart->removeItem($item); //TODO remove position or product?
    }
}
