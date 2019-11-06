<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Service\ShoppingCart;

use ShoppingCart\Domain\Exception\ShoppingCartException;
use ShoppingCart\Domain\Model\Product;
use ShoppingCart\Domain\Repository\ShoppingCartRepository;
use ShoppingCart\Domain\Repository\WarehouseRepository;

class AddItemServiceImpl implements AddItemService
{
    /**
     * @var ShoppingCartRepository
     */
    private $shoppingCartRepository;

    /**
     * @var WarehouseRepository
     */
    private $warehouseRepository;

    public function __construct(
        ShoppingCartRepository $shoppingCartRepository,
        WarehouseRepository $warehouseRepository
    ) {
        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->warehouseRepository = $warehouseRepository;
    }

    public function add(Product $product, int $quantity): void
    {
        if ($product->lessThanMinimumOrderQuantity($quantity)) {
            throw ShoppingCartException::lessThanMinimumOrderQuantity();
        }

        if ($this->warehouseRepository->isNotEnough($product, $quantity)) {
            throw ShoppingCartException::largerThanAvailableInWarehouse();
        }

        $shoppingCart = $this->shoppingCartRepository->getShoppingCart();
        $shoppingCart->addItem($product, $quantity);
    }
}
