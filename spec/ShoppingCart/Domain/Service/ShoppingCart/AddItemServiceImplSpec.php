<?php

namespace spec\ShoppingCart\Domain\Service\ShoppingCart;

use PhpSpec\ObjectBehavior;
use ShoppingCart\Domain\Model\ShoppingCart;
use ShoppingCart\Domain\Model\Product;

class AddItemServiceImplSpec extends ObjectBehavior
{
    public function let(ShoppingCart $shoppingCart)
    {
        $this->beConstructedWith($shoppingCart);
    }

    public function it_adds_item_to_shopping_cart(
        ShoppingCart $shoppingCart,
        Product $product
    ) {
        //Given
        $quantity = 2;

        //When
        $this->add($product, $quantity);

        //Then
        $shoppingCart->addItem($product, $quantity)->shouldHaveBeenCalled();
    }
}
