<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function ($className) {
    $baseDir = __DIR__ . '/src/';
    $filePath = str_replace(['App\\', '\\'], ['', '/'], $className) . '.php';
    $fullPath = $baseDir . $filePath;

    if (file_exists($fullPath)) {
        require $fullPath;
    } else {
        error_log("Autoload failed: $fullPath not found.");
    }
});

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use App\Services\DataBaseConnection;
use App\Controller\Products;

// Initialize Twig
$loader = new FilesystemLoader(__DIR__ . '/templates/');
$twig = new Environment($loader, [
    'cache' => false, // Set a directory path for production caching
]);

// Connect to the database
$connectionObject = new DataBaseConnection(
    $_SERVER['DB_HOST'],
    $_SERVER['DB_USER'],
    $_SERVER['DB_PASS'],
    $_SERVER['DB_NAME'],
    $_SERVER['DB_PORT'],
);

$connect = $connectionObject->connect();

// Fetch products
$products = Products::getProducts($connect);

// Handle AJAX requests
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (isset($_POST['checked_products']) && is_array($_POST['checked_products'])) {
        $pricingProducts = array_column($products, 'price', 'code');
        $selectedProducts = $_POST['checked_products'];
        $expandedSelectedProducts = Products::expandedSelectedProducts($selectedProducts);
        $priceProducts = Products::priceProducts($pricingProducts, $expandedSelectedProducts);
        $totalProductsPrice = ($priceProducts > 0) ? Products::totalProductsPrice($priceProducts) : 0;
        echo json_encode([
            'status' => 'success',
            'checked_products' => $totalProductsPrice
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No checked products found'
        ]);
    }
} else {
    echo $twig->render('index.html.twig', ['products' => $products]);
}
