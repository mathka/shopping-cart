<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Exception;

class ShoppingCartException extends \DomainException
{
    public static function lessThanMinimumOrderQuantity(): self
    {
        return new self('The quantity is less than the minimum required quantity of the product');
    }

    public static function largerThanAvailableInWarehouse(): self
    {
        return new self('The quantity of product is larger than currently available in the warehouse');
    }
}
