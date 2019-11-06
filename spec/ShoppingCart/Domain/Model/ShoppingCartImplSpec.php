<?php

namespace spec\ShoppingCart\Domain\Model;

use PhpSpec\ObjectBehavior;
use ShoppingCart\Domain\Model\ShoppingCartItem;
use ShoppingCart\Domain\Model\ShoppingCartItemList;
use ShoppingCart\Domain\Model\Product;

class ShoppingCartImplSpec extends ObjectBehavior
{
    public function let(ShoppingCartItemList $itemList)
    {
        $this->beConstructedWith($itemList);
    }

    public function it_adds_product_and_its_quantity_as_item_to_list(
        Product $product,
        ShoppingCartItemList $itemList
    ) {
        //Given
        $quantity = 2;
        $wrappedProduct = $product->getWrappedObject();

        //When
        $this->addItem($product, $quantity);

        //Then
        $item = new ShoppingCartItem($wrappedProduct, $quantity);
        $itemList->add($item)->shouldHaveBeenCalled();
    }

    public function it_removes_product_from_list(
        Product $product,
        ShoppingCartItemList $itemList,
        ShoppingCartItem $item
    ) {
        //Given
        $wrappedProduct = $product->getWrappedObject();
        $itemList->findByProduct($product)->willReturn($item);

        //When
        $this->removeItem($product);

        //Then
        $itemList->remove($item)->shouldHaveBeenCalled();
    }
}
