<?php

declare(strict_types=1);

namespace ShoppingCart\Domain\Exception;

class ShoppingCartException extends \DomainException
{
    public static function lessThanMinimumOrderQuantity(): self
    {
        return new self('The quantity provided was less than the minimum required quantity of the product');
    }
}
