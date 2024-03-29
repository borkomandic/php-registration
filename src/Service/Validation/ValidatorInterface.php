<?php

namespace App\Service\Validation;

interface ValidatorInterface
{
    public function validate($value, array $context = []): bool;
    public function getErrorMessage(): string;
}
