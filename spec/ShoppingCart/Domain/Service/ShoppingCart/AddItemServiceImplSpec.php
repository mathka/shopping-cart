<?php

namespace spec\ShoppingCart\Domain\Service\ShoppingCart;

use PhpSpec\ObjectBehavior;
use ShoppingCart\Domain\Exception\ShoppingCartException;
use ShoppingCart\Domain\Model\ShoppingCart;
use ShoppingCart\Domain\Model\Product;
use ShoppingCart\Domain\Repository\ShoppingCartRepository;

class AddItemServiceImplSpec extends ObjectBehavior
{
    public function let(ShoppingCartRepository $shoppingCartRepository)
    {
        $this->beConstructedWith($shoppingCartRepository);
    }

    public function it_adds_item_to_shopping_cart(
        ShoppingCartRepository $shoppingCartRepository,
        ShoppingCart $shoppingCart,
        Product $product
    ) {
        //Given
        $quantity = 2;
        $product->hasLargerMinimumOrderQuantity($quantity)->willReturn(false);
        $shoppingCartRepository->getShoppingCart()->willReturn($shoppingCart);

        //When
        $this->add($product, $quantity);

        //Then
        $shoppingCart->addItem($product, $quantity)->shouldHaveBeenCalled();
    }

    public function it_should_not_allow_item_to_be_added_when_product_quantity_is_less_than_minimum_required_for_product(
        ShoppingCartRepository $shoppingCartRepository,
        ShoppingCart $shoppingCart,
        Product $product
    ) {
        //Given
        $quantity = 0;
        $product->hasLargerMinimumOrderQuantity($quantity)->willReturn(true);
        $shoppingCartRepository->getShoppingCart()->willReturn($shoppingCart);

        // Then
        $this->shouldThrow(ShoppingCartException::lessThanMinimumOrderQuantity())

        // When
            ->duringAdd($product, $quantity);
    }
}
