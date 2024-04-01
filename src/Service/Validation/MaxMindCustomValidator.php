<?php

namespace App\Service\Validation;

use App\Service\RestClientService;
use Exception;
use MaxMind\MinFraud;

class MaxMindCustomValidator implements ValidatorInterface
{
    private $field = 'email';
    private $errorMessage = '';

    public function getField(): string
    {
        return $this->field;
    }

    public function validate($value, array $context = []): bool
    {
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $time = gmdate('Y-m-d\TH:i:s\Z');
        $type = 'account_creation';
        $address = $value;
        $domain = explode('@', $address)[1];

        $restClient = new RestClientService($_ENV['MAX_MIND_ID'], $_ENV['MAX_MIND_KEY']);

        $postData = json_encode([
            'device' => [
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent
            ],
            'email' => [
                'address' => $address,
                'domain' => $domain
            ],
            'event' => [
                'time' => $time,
                'type' => $type
            ]
        ]);

        $response = $restClient->post($_ENV['MAX_MIND_SCORE_API_URL'], $postData, ['Content-Type: application/json']);
        $responseArray = json_decode($response, true);
        $riskScore = $responseArray['risk_score'] ?? null;

        if ($riskScore === null) {
            $this->errorMessage = 'maxmind_error';
            return false;
        }

        if ($riskScore > $_ENV['MAX_MIND_RISK_LIMIT']) {
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
