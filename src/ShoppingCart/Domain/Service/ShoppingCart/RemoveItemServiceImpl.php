<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Service\ShoppingCart;

use ShoppingCart\Domain\Model\Product;
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

    public function remove(Product $product): void
    {
        $shoppingCart = $this->shoppingCartRepository->getShoppingCart();
        $shoppingCart->removeItem($product);
    }
}
