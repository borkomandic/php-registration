<?php

namespace App\Service\Validation;

class PasswordValidator implements ValidatorInterface
{
    private $field = 'password';
    private $errorMessage = '';

    public function getField(): string
    {
        return $this->field;
    }

    public function validate($value, array $context = []): bool
    {
        if (empty($value) || mb_strlen($value) < 8) {
            $this->errorMessage = 'Password must be at least 8 characters.';
            return false;
        }

        if ($value !== $context['password2']) {
            $this->errorMessage = 'Passwords do not match.';
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
