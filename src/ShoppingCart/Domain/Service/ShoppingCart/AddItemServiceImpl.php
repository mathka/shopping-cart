<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Service\ShoppingCart;

use ShoppingCart\Domain\Exception\ShoppingCartException;
use ShoppingCart\Domain\Model\Product;
use ShoppingCart\Domain\Repository\ShoppingCartRepository;

class AddItemServiceImpl implements AddItemService
{
    /**
     * @var ShoppingCartRepository
     */
    private $shoppingCartRepository;

    public function __construct(ShoppingCartRepository $shoppingCartRepository)
    {
        $this->shoppingCartRepository = $shoppingCartRepository;
    }

    public function add(Product $product, int $quantity): void
    {
        if ($product->hasLargerMinimumOrderQuantity($quantity)) {
            throw ShoppingCartException::lessThanMinimumOrderQuantity();
        }

        $shoppingCart = $this->shoppingCartRepository->getShoppingCart();
        $shoppingCart->addItem($product, $quantity);
    }
}
