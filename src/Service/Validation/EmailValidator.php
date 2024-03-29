<?php

namespace App\Service\Validation;

class EmailValidator implements ValidatorInterface
{
    private $errorMessage = '';

    public function validate($value, array $context = []): bool
    {
        // Implement email validation logic here, including checking for email uniqueness and MaxMind validation.
        // Since MaxMind is a simulated external call, simply assume it returns true for demonstration.
        $isEmailValid = filter_var($value, FILTER_VALIDATE_EMAIL);
        $isNotFraudulent = true; // Simulate MaxMind check.

        if (!$isEmailValid || !$isNotFraudulent) {
            $this->errorMessage = 'Invalid email or email flagged by MaxMind.';
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
