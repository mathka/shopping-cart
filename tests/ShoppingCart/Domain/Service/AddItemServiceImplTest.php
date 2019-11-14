<?php

declare(strict_types=1);

namespace tests\ShoppingCart\Domain\Service;

use PHPUnit\Framework\TestCase;
use ShoppingCart\Domain\Exception\ShoppingCartException;
//TODO dependency on implementation, not abstraction...
use ShoppingCart\Domain\Factory\ShoppingCartFactoryImpl;
use ShoppingCart\Domain\Model\Item;
use ShoppingCart\Domain\Model\Product;
use ShoppingCart\Domain\Model\ShoppingCart;
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
     * @var ShoppingCart
     */
    private $shoppingCart;

    /**
     * @var WarehouseRepository
     */
    private $warehouseRepository;

    public function setUp()
    {
        $this->shoppingCart = $this->createShoppingCart();
        $this->warehouseRepository = $this->createWarehouseRepository();

        $this->service = new AddItemServiceImpl(
            $this->createShoppingCartRepository($this->shoppingCart),
            $this->warehouseRepository
        );
    }

    public function testAddItemsToShoppingCart()
    {
        // Given
        $quantity1 = 2;
        $product1 = $this->createProduct(false);

        $quantity2 = 3;
        $product2 = $this->createProduct(false);

        $this->warehouseRepository->expects($this->any())->method('isNotEnough')->willReturn(false);

        //When
        $this->service->add($product1, $quantity1);
        $this->service->add($product2, $quantity2);

        //Then
        $itemList = $this->shoppingCart->getItemList();
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
        $product = $this->createProduct(true);

        //Then
        $this->expectException(ShoppingCartException::class);
        $this->expectExceptionMessage(ShoppingCartException::lessThanMinimumOrderQuantity()->getMessage());

        //When
        $this->service->add($product, self::QUANTITY);
    }

    public function testDoesNotAddItemWhenProductQuantityIsNotAvailableInWarehouse()
    {
        // Given
        $product = $this->createProduct(false);
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
        //TODO - clean this!
        $factory = new ShoppingCartFactoryImpl();

        return $factory->create();
    }

    private function createShoppingCartRepository(ShoppingCart $shoppingCart): ShoppingCartRepository
    {
        $shoppingCartRepository = $this->createMock(ShoppingCartRepository::class);
        $shoppingCartRepository->method('getShoppingCart')->willReturn($shoppingCart);

        return $shoppingCartRepository;
    }

    private function createWarehouseRepository(): WarehouseRepository
    {
        return $this->createMock(WarehouseRepository::class);
    }

    private function createProduct($lessThanMinimumOrderQuantity = false): Product
    {
        $product = $this->createMock(Product::class);
        $product->method('lessThanMinimumOrderQuantity')->willReturn($lessThanMinimumOrderQuantity);

        return $product;
    }
}
