<?php

namespace spec\ShoppingCart\Domain\Model;

use ShoppingCart\Domain\Model\ItemList;
use ShoppingCart\Domain\Model\Product;
use PhpSpec\ObjectBehavior;

class ShoppingCartImplSpec extends ObjectBehavior
{
    public function let(ItemList $itemList)
    {
        $this->beConstructedWith($itemList);
    }

    public function it_adds_product_and_its_quantity_to_list(
        Product $product,
        ItemList $itemList
    ) {
        //Given
        $quantity = 2;

        //When
        $this->addItem($product, $quantity);

        //Then
        $itemList->add($product, $quantity)->shouldHaveBeenCalled();
    }
}
