<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controller\RegistrationController;

$controller = new RegistrationController();
$controller->register();
