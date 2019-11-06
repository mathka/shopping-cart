<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Model;

class ShoppingCartItem implements Item
{
//    /**
//     * @var int
//     */
//    private $id;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

//    //Test it
//    public function getId(): int
//    {
//        return $this->id;
//    }
}
