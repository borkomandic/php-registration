<?php

namespace App\Controller;

use App\Service\RegistrationService;

class RegistrationController
{
    private $registrationService;

    public function __construct()
    {
        $this->registrationService = new RegistrationService();
    }

    public function register()
    {
        $email = $_REQUEST['email'] ?? '';
        $password = $_REQUEST['password'] ?? '';
        $password2 = $_REQUEST['password2'] ?? '';

        $response = $this->registrationService->registerUser($email, $password, $password2);

        echo json_encode($response);
    }
}
