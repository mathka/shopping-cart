<?php

namespace spec\ShoppingCart\Domain\Service;

use PhpSpec\ObjectBehavior;
use ShoppingCart\Domain\Model\ShoppingCart;
use ShoppingCart\Domain\Service\ShoppingCartServiceImpl;
use ShoppingCart\Domain\Model\Product;

class ShoppingCartServiceImplSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(ShoppingCartServiceImpl::class);
    }

    public function let(ShoppingCart $shoppingCart)
    {
        $this->beConstructedWith($shoppingCart);
    }

    public function it_adds_product_to_shopping_cart(
        ShoppingCart $shoppingCart,
        Product $product
    ) {
        //Given
        $quantity = 2;

        //When
        $this->addProduct($product, $quantity);

        //Then
        $shoppingCart->addProduct($product, $quantity)->shouldHaveBeenCalled();
    }
}
