<?php

declare(strict_types=1);

namespace tests\ShoppingCart\Domain\Service;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ShoppingCart\Domain\Exception\ShoppingCartException;
use ShoppingCart\Domain\Model\Item;
use ShoppingCart\Domain\Model\Product;
use ShoppingCart\Domain\Model\ShoppingCart;
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
    private const QUANTITY = 2;

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
        $this->shoppingCart = $this->createShoppingCart();
        $shoppingCartRepository = $this->createShoppingCartRepository($this->shoppingCart);
        $this->warehouseRepository = $this->createMock(WarehouseRepository::class);

        $this->service = new AddItemServiceImpl($shoppingCartRepository, $this->warehouseRepository);
    }

    public function testAddItemsToShoppingCart()
    {
        // Given
        $quantity = 2;
        $product = $this->createMock(Product::class);
        $product->method('lessThanMinimumOrderQuantity')->willReturn(false);
        $this->warehouseRepository->expects($this->once())
            ->method('isNotEnough')
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
        $product1->method('lessThanMinimumOrderQuantity')->willReturn(false);

        $quantity2 = 3;
        $product2 = $this->createMock(Product::class);
        $product2->method('lessThanMinimumOrderQuantity')->willReturn(false);

        $this->warehouseRepository->expects($this->any())->method('isNotEnough')->willReturn(false);

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
        $product = $this->createProductMock(true);

        //Then
        $this->expectException(ShoppingCartException::class);
        $this->expectExceptionMessage(ShoppingCartException::lessThanMinimumOrderQuantity()->getMessage());

        //When
        $this->service->add($product, self::QUANTITY);
    }

    public function testDoesNotAddItemWhenProductQuantityIsNotAvailableInWarehouse()
    {
        // Given
        $product = $this->createProductMock(false);
        $this->warehouseRepository->expects($this->once())
            ->method('isNotEnough')
            ->with($product, self::QUANTITY)
            ->willReturn(true);

        //Then
        $this->expectException(ShoppingCartException::class);
        $this->expectExceptionMessage(ShoppingCartException::largerThanAvailableInWarehouse()->getMessage());

        //When
        $this->service->add($product, self::QUANTITY);
    }

    private function createShoppingCart(): ShoppingCart
    {
        return new ShoppingCartImpl(
            new ShoppingCartItemList()
        );
    }

    private function createShoppingCartRepository(ShoppingCart $shoppingCart): ShoppingCartRepository
    {
        $shoppingCartRepository = $this->createMock(ShoppingCartRepository::class);
        $shoppingCartRepository->method('getShoppingCart')->willReturn($shoppingCart);

        return $shoppingCartRepository;
    }

    /**
     * @param bool $lessThanMinimumOrderQuantity
     *
     * @return MockObject|Product
     *
     * @throws \ReflectionException
     */
    private function createProductMock($lessThanMinimumOrderQuantity = false): MockObject
    {
        $product = $this->createMock(Product::class);
        $product->method('lessThanMinimumOrderQuantity')->willReturn($lessThanMinimumOrderQuantity);

        return $product;
    }
}
