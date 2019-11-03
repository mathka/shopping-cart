<?php

namespace spec\ShoppingCart\Domain\Model;

use PhpSpec\ObjectBehavior;
use ShoppingCart\Domain\Model\ShoppingCartItem;

class ShoppingCartItemListSpec extends ObjectBehavior
{
    public function it_adds_item_to_list(ShoppingCartItem $item)
    {
        //When
        $this->add($item);

        //Then
        $result = $this->getList();
        $result->shouldBe([
            $item,
        ]);
    }
}
