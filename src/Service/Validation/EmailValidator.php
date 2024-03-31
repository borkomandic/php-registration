<?php

namespace App\Service\Validation;

class EmailValidator implements ValidatorInterface
{
    private $field = 'email';
    private $errorMessage = '';

    public function getField(): string
    {
        return $this->field;
    }

    public function validate($value, array $context = []): bool
    {
        $isEmailValid = filter_var($value, FILTER_VALIDATE_EMAIL);

        if (!$isEmailValid) {
            $this->errorMessage = 'email_format';
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
