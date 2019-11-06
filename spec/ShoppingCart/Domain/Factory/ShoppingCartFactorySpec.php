<?php

namespace spec\ShoppingCart\Domain\Factory;

use PhpSpec\ObjectBehavior;
use ShoppingCart\Domain\Model\ShoppingCartImpl;
use ShoppingCart\Domain\Model\ShoppingCartItemList;
use ShoppingCart\Domain\Model\Product;

class ShoppingCartFactoryImplSpec extends ObjectBehavior
{
    public function it_creates_shopping_cart(
        Product $product,
        ShoppingCartItemList $itemList
    ) {
        //When
        $result = $this->create();

        //Then
        $result->shouldBeLike(
            new ShoppingCartImpl(
                new ShoppingCartItemList()
            )
        );
    }
}
