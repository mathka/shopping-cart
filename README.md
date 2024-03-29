# SHOPPING CART

## Description

Goal: An attempt to implement a shopping cart according to Clean Architecture.
The domain should be completely disconnected from the framework (this condition does not apply to tests).

Object-based shopping cart mechanism (model) based on tests (TDD). It contains elements such as: product, shopping cart, item in the shopping cart, order.

## Additional guidelines:
- each product has its name and price (+ quantity available in the warehouse),
- when adding a product to the basket, the user gives the quantity of ordered items,
- products have a defined minimum quantity that can be ordered; by default, it should be 1 for each product; if the user selects a smaller amount, an error (exception) will be returned,
- this is a variant / proposal to implement the business model, it does not operate on any database

## Use cases / acceptance criteria:

1. [clean up in progress] Adding the product to the shopping cart
    - the minimum required quantity of items for a given product has been added - success
    - more than the minimum required quantity of items for a given product has been added - success
    - less than the minimum required quantity of items for a given product has been added - failure
    - a larger quantity than was available in the warehouse has been added - failure

2. [TODO] Placing an order
    - MVP: payment on delivery and personal pickup, therefore only the shopping cart is sufficient to place an order
    - the accepted order should trigger cleanup the shopping cart - success
    - if the shopping cart is empty, it will not be possible to accept the order - failure
    - if any of the products is no longer available, it will not be possible to accept the order - failure
    - if the quantity of any product exceeds the quantity available in the warehouse, it will not be possible to accept the order - failure

3. [TODO] Getting of the shopping cart
    - a list of items in the shopping cart and the total price are expected
    - each item should contain the product name, identifier (find product details), quantity, unit price
    - the total price should be the result of adding prices for all products, after multiplying them by ordered quantity

4. [TODO] Removing the product from the shopping cart
    - the item has been deleted - success
    - an attempt was made to delete an item that has already been removed from the shopping cart - failure

5. [TODO] Changing the quantity of a given product in the shopping cart
    - Increasing
        - quantity was available in the warehouse - success
        - expected quantity was not available in the warehouse - failure
    - Reducing
        - it was possible to reduce it to the given quantity - success
        - the quantity is zero - complete removal of the product from the shopping cart - success
        - the quantity provided was less than the minimum required quantity of the product, but greater than zero - failure
        - the quantity is negative - failure
