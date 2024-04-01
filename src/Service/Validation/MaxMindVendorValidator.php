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
        // TODO: remove all sandbox stuff, before going to production

        // sanbox minfroud object
        //$mf = new MinFraud($_ENV['MAX_MIND_ID'], $_ENV['MAX_MIND_KEY'], ['host' => 'sandbox.maxmind.com']);

        $mf = new MinFraud($_ENV['MAX_MIND_ID'], $_ENV['MAX_MIND_KEY']);
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        // Sandbox testing for score 40-90
        //$ipAddress = '128.101.101.101';

        // Sandbox testing for score 5-39.99
        //$ipAddress = '74.209.24.1';

        // Sandbox testing for score 0.01-4.99
        //$ipAddress = '65.116.3.80';

        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $time = gmdate('Y-m-d\TH:i:s\Z');
        $type = 'account_creation';
        $address = $context['email'];
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
