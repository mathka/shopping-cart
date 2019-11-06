<?php

namespace spec\ShoppingCart\Domain\Service\ShoppingCart;

use PhpSpec\ObjectBehavior;
use ShoppingCart\Domain\Exception\ShoppingCartException;
use ShoppingCart\Domain\Model\ShoppingCart;
use ShoppingCart\Domain\Model\Product;
use ShoppingCart\Domain\Repository\ShoppingCartRepository;
use ShoppingCart\Domain\Repository\WarehouseRepository;

class AddItemServiceImplSpec extends ObjectBehavior
{
    private const QUANTITY = 2;

    public function let(
        ShoppingCartRepository $shoppingCartRepository,
        WarehouseRepository $warehouseRepository
    ) {
        $this->beConstructedWith($shoppingCartRepository, $warehouseRepository);
    }

    public function it_adds_item_to_shopping_cart(
        ShoppingCartRepository $shoppingCartRepository,
        WarehouseRepository $warehouseRepository,
        ShoppingCart $shoppingCart,
        Product $product
    ) {
        //Given
        $product->lessThanMinimumOrderQuantity(self::QUANTITY)->willReturn(false);
        $warehouseRepository->isNotEnough($product, self::QUANTITY)->willReturn(false);

        $shoppingCartRepository->getShoppingCart()->willReturn($shoppingCart);

        //When
        $this->add($product, self::QUANTITY);

        //Then
        $shoppingCart->addItem($product, self::QUANTITY)->shouldHaveBeenCalled();
    }

    public function it_does_not_add_item_when_product_quantity_is_less_than_minimum_required_for_product(
        ShoppingCartRepository $shoppingCartRepository,
        ShoppingCart $shoppingCart,
        Product $product
    ) {
        //Given
        $product->lessThanMinimumOrderQuantity(self::QUANTITY)->willReturn(true);

        $shoppingCartRepository->getShoppingCart()->willReturn($shoppingCart);

        // Then
        $this->shouldThrow(ShoppingCartException::lessThanMinimumOrderQuantity())

        // When
            ->duringAdd($product, self::QUANTITY);
    }

    public function it_does_not_add_item_when_product_quantity_is_larger_than_quantity_available_in_warehouse(
        WarehouseRepository $warehouseRepository,
        Product $product
    ) {
        //Given
        $product->lessThanMinimumOrderQuantity(self::QUANTITY)->willReturn(false);
        $warehouseRepository->isNotEnough($product, self::QUANTITY)->willReturn(true);

        // Then
        $this->shouldThrow(ShoppingCartException::largerThanAvailableInWarehouse())

        // When
            ->duringAdd($product, self::QUANTITY);
    }
}
