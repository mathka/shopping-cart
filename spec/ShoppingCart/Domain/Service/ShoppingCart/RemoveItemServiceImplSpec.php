<?php

namespace spec\ShoppingCart\Domain\Service\ShoppingCart;

use ShoppingCart\Domain\Model\Product;
use ShoppingCart\Domain\Model\ShoppingCart;
use ShoppingCart\Domain\Repository\ShoppingCartRepository;
use PhpSpec\ObjectBehavior;

class RemoveItemServiceImplSpec extends ObjectBehavior
{
    public function let(ShoppingCartRepository $shoppingCartRepository)
    {
        $this->beConstructedWith($shoppingCartRepository);
    }

    public function it_removes_item_from_shopping_cart(
        ShoppingCartRepository $shoppingCartRepository,
        ShoppingCart $shoppingCart,
        Product $product
    ) {
        //TODO
//        //Given
//        $shoppingCartRepository->getShoppingCart()->willReturn($shoppingCart);
//
//        //When
//        $this->remove($product);
//
//        //Then
//        $shoppingCart->removeItem($product)->shouldHaveBeenCalled();
    }
}
