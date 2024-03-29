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
        // Due to the simplicity of the system, we'll use the query params as the only content for $context,
        // but it can contain all sort of global app data
        $context = $values;

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
