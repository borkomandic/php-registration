<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controller\RegistrationController;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$controller = new RegistrationController();
$controller->register();
