<?php

namespace App\Service\Validation;

class ValidatorComposite implements ValidatorInterface
{
    private $validators;
    private $errorMessage;

    public function __construct(array $validators)
    {
        $this->validators = $validators;
    }

    public function validate($values, array $context = []): bool
    {
        foreach ($this->validators as $validator) {
            if (!$validator->validate($values[$validator->getField()], $context)) {
                $this->errorMessage = $validator->getErrorMessage();
                return false;
            }
        }
        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
