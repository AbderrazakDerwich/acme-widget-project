<?php

spl_autoload_register(function ($className) {
    $baseDir = __DIR__ . '/../src/';
    $filePath = str_replace(['App\\', '\\'], ['', '/'], $className) . '.php';
    $fullPath = $baseDir . $filePath;
    if (file_exists($fullPath)) {
        require $fullPath;
    } else {
        error_log("Autoload failed: $fullPath not found.");
    }
});

use PHPUnit\Framework\TestCase;
use App\Controller\Products;

class ProductsTest extends TestCase
{
    public function testPriceProductsSuccess(): void
    {
        $pricingProducts = [
            'P01' => 10.00,
            'P02' => 15.00
        ];

        $selectedProducts = ['P01', 'P02', 'P01'];

        $result = Products::priceProducts($pricingProducts, $selectedProducts);

        // The total is 10 + 15 + 10 = 35.00
        $this->assertEquals(35.00, $result);
    }

    public function testExpandedSelectedProducts(): void
    {
        $inputArray = ['P01' => 2, 'P02' => 1];
        $result = Products::expandedSelectedProducts($inputArray);

        // Expect ['P01', 'P01', 'P02']
        $this->assertEquals(['P01', 'P01', 'P02'], $result);
    }

    public function testTotalProductsPrice(): void
    {
        $this->assertEquals('39.95', Products::totalProductsPrice(35.00));
        $this->assertEquals('52.95', Products::totalProductsPrice(50.00));
        $this->assertEquals('54.95', Products::totalProductsPrice(52.00));
    }
}
