<?php

namespace App\Service\Validation;

use Exception;
use MaxMind\MinFraud;

class MaxMindVendorValidator implements ValidatorInterface
{
    private $field = 'email';
    private $errorMessage = '';

    public function getField(): string
    {
        return $this->field;
    }

    public function validate($value, array $context = []): bool
    {
        $mf = new MinFraud($_ENV['MAX_MIND_ID'], $_ENV['MAX_MIND_KEY']);
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $time = gmdate('Y-m-d\TH:i:s\Z');
        $type = 'account_creation';
        $address = $value;
        $domain = explode('@', $address)[1];

        $request = $mf->withDevice([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ])->withEvent([
            'time' => $time,
            'type' => $type,
        ])->withEmail([
            'address' => $address,
            'domain' => $domain,
        ]);

        // in case max mind authentication fails...
        try {
            $scoreResponse = $request->score();
        } catch (Exception $e) {
            $this->errorMessage = 'maxmind_error';
            return false;
        }

        if ($scoreResponse->riskScore > $_ENV['MAX_MIND_RISK_LIMIT']) {
            $this->errorMessage = 'email_insecure';
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
