<?php

namespace App\Service;

use App\Service\Validation\ValidatorComposite;
use App\Service\Validation\EmailValidator;
use App\Service\Validation\PasswordValidator;
use App\Repository\UserRepository;
use App\Utils\Database;

class RegistrationService
{
    private $userRepository;
    private $validator;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->validator = new ValidatorComposite([
            new EmailValidator(),
            new PasswordValidator(),
        ]);
    }

    public function registerUser($email, $password, $password2)
    {
        if (!$this->validator->validate(['email' => $email, 'password' => $password, 'password2' => $password2])) {
            return ['success' => false, 'error' => $this->validator->getErrorMessage()];
        }

        if ($this->userRepository->findByEmail($email)) {
            return ['success' => false, 'error' => 'Email already exists'];
        }

        $userId = $this->userRepository->insertUser($email, $password);


        dd($userId);

        $this->userRepository->insertUserLog($userId, 'register');

        return ['success' => true, 'userId' => $userId];
    }
}
