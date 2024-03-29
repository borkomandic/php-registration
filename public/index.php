<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controller\RegistrationController;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Capture the 'my-app-path' parameter as the routing path
$myAppPath = $_GET['my-app-path'] ?? '';

// Simple routing mechanism
switch ($myAppPath) {
    case 'register':
        // You can access other query parameters as usual, for example:
        // $param = $_GET['param'] ?? 'default_value';

        $controller = new RegistrationController();
        $controller->register();
        break;

    // More cases for different routes can be added here

    default:
        echo "404 Not Found";
        break;
}

