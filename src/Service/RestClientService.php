<?php

namespace App\Service;

class RestClientService
{
    private $username;
    private $password;

    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function get($url, $headers = [])
    {
        return $this->sendRequest('GET', $url, null, $headers);
    }

    public function post($url, $body, $headers = [])
    {
        return $this->sendRequest('POST', $url, $body, $headers);
    }

    private function sendRequest($method, $url, $body = null, $headers = [])
    {
        $curl = curl_init();

        if (!is_null($this->username) && !is_null($this->password)) {
            $basicAuthHeader = 'Authorization: Basic ' . base64_encode($this->username . ':' . $this->password);
            $headers[] = $basicAuthHeader;
        }

        switch ($method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                if ($body) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
                }
                break;
            case 'GET':
                break;
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            // Consider logging the error or throwing an exception
        }

        curl_close($curl);

        return $response;
    }
}
