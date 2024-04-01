<?php

namespace App\Service;

use App\Service\Validation\MaxMindCustomValidator;
use App\Service\Validation\ValidatorComposite;
use App\Service\Validation\EmailValidator;
use App\Service\Validation\MaxMindVendorValidator;
use App\Service\Validation\PasswordValidator;
use App\Repository\UserRepository;

class RegistrationService
{
    private $userRepository;
    private $validator;

    public function __construct()
    {
        $this->userRepository = new UserRepository();

        $validatorsToUse = [
            new EmailValidator(),
            new PasswordValidator(),
        ];

        if ($_ENV['MAX_MIND_CUSTOM_VALIDATOR_ENABLED']) $validatorsToUse[] = new MaxMindCustomValidator();
        if ($_ENV['MAX_MIND_VENDOR_VALIDATOR_ENABLED']) $validatorsToUse[] = new MaxMindVendorValidator();

        $this->validator = new ValidatorComposite($validatorsToUse);
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

        $this->userRepository->insertUserLog($userId, 'register');

        $emailService = new EmailService();
        $emailService->sendWelcomeEmail($email);

        return ['success' => true, 'userId' => $userId];
    }
}
