<?php

namespace NextcloudApi;

use Curl\Curl;
use Exception;

class NextcloudApiClient
{
    protected Curl $curl;
    protected string $baseUrl;

    public function __construct() {
        $this->curl = new Curl();
        $this->curl->setTimeout(15);
        $this->curl->setConnectTimeout(10);
        $this->curl->setBasicAuthentication($_ENV['NEXTCLOUD_USERNAME'], $_ENV['NEXTCLOUD_PASSWORD']);
        $this->curl->setHeader('OCS-APIRequest', 'true');
        $this->curl->setHeader('Accept', 'application/json');
        $this->curl->setDefaultJsonDecoder(true);

        $this->baseUrl = rtrim($_ENV['NEXTCLOUD_URL'], '/');
    }

    protected function request(
        string $method,
        string $endpoint,
        array $data = []
    ): array {

        $url = $this->baseUrl . $endpoint;

        switch (strtoupper($method)) {

            case 'GET':
                $this->curl->get($url, $data);
                break;

            case 'POST':
                $this->curl->post($url, $data);
                break;

            case 'PUT':
                $this->curl->put($url, $data);
                break;

            case 'DELETE':
                $this->curl->delete($url, $data);
                break;

            default:
                throw new Exception('Unsupported HTTP method.');
        }

        if ($this->curl->error) {
            throw new Exception('Request failed: ' .$this->curl->errorMessage);
        }

        $status = $this->curl->httpStatusCode;

        if ($status === 401) {
            throw new Exception('Invalid Nextcloud credentials.');
        }

        if ($status === 404) {
            throw new Exception('Nextcloud API endpoint not found.');
        }

        if ($status >= 500) {
            throw new Exception('Nextcloud server error.');
        }

        if ($status >= 400) {
            throw new Exception('Nextcloud returned HTTP ' . $status);
        }

        $response = $this->curl->response;

        if (!is_array($response)) {
            throw new Exception(
                'Nextcloud did not return valid JSON.'
            );
        }

        if (!isset($response['ocs'])) {
            throw new Exception('Invalid response from Nextcloud.');
        }

        $meta = $response['ocs']['meta'] ?? null;

        if (!$meta) {
            throw new Exception('Missing OCS metadata.');
        }

        if ($meta['statuscode'] !== 100) {
            throw new Exception($meta['message'] ?: 'Unknown Nextcloud API error.');
        }

        return $response;
    }

    public function get(string $endpoint, array $data = []): array
    {
        return $this->request(
            'GET',
            $endpoint,
            $data
        );
    }

    public function post(string $endpoint, array $data = []): array
    {
        return $this->request(
            'POST',
            $endpoint,
            $data
        );
    }

    public function put(string $endpoint, array $data = []): array
    {
        return $this->request(
            'PUT',
            $endpoint,
            $data
        );
    }

    public function delete(string $endpoint, array $data = []): array
    {
        return $this->request(
            'DELETE',
            $endpoint,
            $data
        );
    }

    public function getCapabilities(): array
    {
        return $this->get('/ocs/v1.php/cloud/capabilities');
    }

    public function createUser(
        string $userId,
        ?string $email = null,
        ?string $password = null,
    ): array
    {
        return $this->post(
            '/ocs/v1.php/cloud/users',
            [
                'userid'      => $userId,
                'email'       => $email,
                'password'    => $password,
            ]
        );
    }
}