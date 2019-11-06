<?php

declare(strict_types=1);

namespace tests\ShoppingCart\Domain\Service;

use PHPUnit\Framework\TestCase;
use ShoppingCart\Domain\Exception\ShoppingCartException;
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
    /**
     * @var WarehouseRepository
     */
    private $warehouseRepository;

    public function setUp()
    {
        //TODO - to clean up (private functions with meaningful names)
        $this->shoppingCart = new ShoppingCartImpl(
            new ShoppingCartItemList()
        );
        $shoppingCartRepository = $this->createMock(ShoppingCartRepository::class);
        $shoppingCartRepository->method('getShoppingCart')->willReturn($this->shoppingCart);
        $this->warehouseRepository = $this->createMock(WarehouseRepository::class);

        $this->service = new AddItemServiceImpl($shoppingCartRepository, $this->warehouseRepository);
    }

    public function testAddItemsToShoppingCart()
    {
        // Given
        $quantity = 2;
        $product = $this->createMock(Product::class);
        $product->method('hasLargerMinimumOrderQuantity')->willReturn(false);
        $this->warehouseRepository->expects($this->once())
            ->method('hasNotEnough')
            ->with($product, $quantity)
            ->willReturn(false);

        //When
        $this->service->add($product, $quantity);

        //Then
        $itemList = $this->shoppingCart->getItemList();
        //TODO - I don't like the name $itemList->getList()...
        $items = $itemList->getList();

        $this->assertCount(1, $items);
        $this->assertInstanceOf(Item::class, $items[0]);
        $this->assertEquals($product, $items[0]->getProduct());
        $this->assertEquals($quantity, $items[0]->getQuantity());
    }

    public function testAllAddedProductsAreAvailableInShoppingCart()
    {
        // Given
        $quantity1 = 2;
        $product1 = $this->createMock(Product::class);
        $product1->method('hasLargerMinimumOrderQuantity')->willReturn(false);

        $quantity2 = 3;
        $product2 = $this->createMock(Product::class);
        $product2->method('hasLargerMinimumOrderQuantity')->willReturn(false);

        $this->warehouseRepository->expects($this->any())->method('hasNotEnough')->willReturn(false);

        //When
        $this->service->add($product1, $quantity1);
        $this->service->add($product2, $quantity2);

        //Then
        $itemList = $this->shoppingCart->getItemList();
        //TODO - I don't like the name $itemList->getList()...
        $items = $itemList->getList();

        $this->assertCount(2, $items);
        $this->assertInstanceOf(Item::class, $items[0]);
        $this->assertEquals($product1, $items[0]->getProduct());
        $this->assertEquals($quantity1, $items[0]->getQuantity());
        $this->assertInstanceOf(Item::class, $items[1]);
        $this->assertEquals($product2, $items[1]->getProduct());
        $this->assertEquals($quantity2, $items[1]->getQuantity());
    }

    public function testDoesNotAddItemWhenProductQuantityIsLessThanMinimumRequiredForProduct()
    {
        // Given
        $quantity = 2;
        $product = $this->createMock(Product::class);
        $product->method('hasLargerMinimumOrderQuantity')->willReturn(true);

        //Then
        $this->expectException(ShoppingCartException::class);
        //TODO - inconsistent function name and message of exception?
        $this->expectExceptionMessage(ShoppingCartException::lessThanMinimumOrderQuantity()->getMessage());

        //When
        $this->service->add($product, $quantity);
    }

    public function testDoesNotAddItemWhenProductQuantityIsNotAvailableInWarehouse()
    {
        // Given
        $quantity = 2;
        $product = $this->createMock(Product::class);
        $product->method('hasLargerMinimumOrderQuantity')->willReturn(false);
        $this->warehouseRepository->expects($this->once())
            ->method('hasNotEnough')
            ->with($product, $quantity)
            ->willReturn(true);

        //Then
        $this->expectException(ShoppingCartException::class);
        //TODO - inconsistent function name and message of exception?
        $this->expectExceptionMessage(ShoppingCartException::largerThanAvailableInWarehouse()->getMessage());

        //When
        $this->service->add($product, $quantity);
    }
}
