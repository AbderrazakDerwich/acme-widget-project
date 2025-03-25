<?php

namespace App\Controller;

use Exception;
use PDO;

class Products
{
    public static function getProducts(PDO $connection): array
    {
        $sql = "SELECT id, product, code, price FROM products";
        try {
            $statement = $connection->query($sql);

            if ($statement === false) {
                throw new Exception("Query failed: " . implode(" ", $connection->errorInfo()));
            }

            $products = [];
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $products[] = $row;
            }

            return $products;
        } catch (Exception $e) {
            throw new Exception("Error fetching products: " . $e->getMessage());
        }
    }


    public static function priceProducts(array $pricingProducts, array $selectedProducts): float
    {
        $total = 0;
        foreach ($selectedProducts as $selectedProduct) {
            if (array_key_exists($selectedProduct, $pricingProducts)) {
                $total += $pricingProducts[$selectedProduct];
            }
        }

        if (isset(array_count_values($selectedProducts)['R01']) && array_count_values($selectedProducts)['R01'] >= 2) {
            $total -= $pricingProducts['R01'] * 0.5;
        }

        return $total;
    }

    public static function expandedSelectedProducts(array $inputArray): array
    {
        $expandedArray = [];
        foreach ($inputArray as $key => $value) {
            if ($value > 0) {
                $expandedArray = array_merge($expandedArray, array_fill(0, $value, $key));
            }
        }

        return $expandedArray;
    }

    public static function totalProductsPrice(float $priceProducts)
    {
        if ($priceProducts >= 90) {
            $price = $priceProducts ;
        } elseif (50 <= $priceProducts && $priceProducts < 90) {
            $price = $priceProducts  + 2.95;
        } else {
            $price = $priceProducts  + 4.95;
        }

        return sprintf("%.2f", floor($price * 100) / 100);
    }
}
