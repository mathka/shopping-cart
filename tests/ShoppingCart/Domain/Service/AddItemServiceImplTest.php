<?php

declare(strict_types=1);

namespace tests\ShoppingCart\Domain\Service;

use PHPUnit\Framework\TestCase;
use ShoppingCart\Domain\Model\Item;
use ShoppingCart\Domain\Model\Product;
use ShoppingCart\Domain\Model\ShoppingCartImpl;
use ShoppingCart\Domain\Model\ShoppingCartItemList;
use ShoppingCart\Domain\Repository\ShoppingCartRepository;
use ShoppingCart\Domain\Repository\WarehouseRepository;
use ShoppingCart\Domain\Service\ShoppingCart\AddItemServiceImpl;

/**
 * @group shopping-cart
 */
class AddItemServiceImplTest extends TestCase
{
    /**
     * @var AddItemServiceImpl
     */
    private $service;

    /**
     * @var ShoppingCartImpl
     */
    private $shoppingCart;

    public function setUp()
    {
        $this->shoppingCart = new ShoppingCartImpl(
            new ShoppingCartItemList()
        );
        $shoppingCartRepository = $this->createMock(ShoppingCartRepository::class);
        $shoppingCartRepository->method('getShoppingCart')->willReturn($this->shoppingCart);
        $warehouseRepository = $this->createMock(WarehouseRepository::class);

        $this->service = new AddItemServiceImpl($shoppingCartRepository, $warehouseRepository);
    }

    public function testAddItemToShoppingCart()
    {
        // Given
        $quantity = 2;
        $product = $this->createMock(Product::class);

        //When
        $this->service->add($product, $quantity);

        //Then
        $itemList = $this->shoppingCart->getItemList();
        $items = $itemList->getList();

        //TODO - names...
        $this->assertCount(1, $items);
        $this->assertInstanceOf(Item::class, $items[0]);
    }
}
