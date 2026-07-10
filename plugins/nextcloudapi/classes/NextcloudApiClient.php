<?php

namespace NextcloudApi;

use Curl\Curl;
use Exception;

class NextcloudApiClient
{
    protected Curl $curl;

    protected string $baseUrl;

    public function __construct(NextcloudApi $nextcloudApi)
    {
        $this->baseUrl = $nextcloudApi->protocol.'://'.rtrim(
            $nextcloudApi->url,
            '/'
        );

        if ($nextcloudApi->port) {
            $this->baseUrl .= ':'.$nextcloudApi->port;
        }

        $this->curl = new Curl;
        $this->curl->setTimeout(15);
        $this->curl->setConnectTimeout(10);

        if ($nextcloudApi->username && $nextcloudApi->password) {
            $this->curl->setBasicAuthentication(
                $nextcloudApi->username,
                $nextcloudApi->password
            );
        }

        $this->curl->setHeader(
            'OCS-APIRequest',
            'true'
        );

        $this->curl->setHeader(
            'Accept',
            'application/json'
        );

        $this->curl->setDefaultJsonDecoder(true);
    }

    /* =========================================================
     * CORE REQUEST
     * ========================================================= */

    protected function request(
        string $method,
        string $endpoint,
        array $data = []
    ): NextcloudApiResponse {

        $url = $this->baseUrl.'/'.ltrim($endpoint, '/');

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
                throw new Exception(
                    'Unsupported HTTP method.'
                );
        }

        if ($this->curl->error) {
            return new NextcloudApiResponse(
                code: $this->curl->getErrorCode(),
                message: $this->curl->getErrorMessage()
            );
        }

        return new NextcloudApiResponse(
            code: $this->curl->getHttpStatusCode(),
            version: $this->curl->response['ocs']['data']['nextcloud']['system']['version'] ?? $this->curl->response['version'],
            meta: $this->curl->response['ocs']['meta'] ?? null,
            data: $this->curl->response['ocs']['data'] ?? $this->curl->response
        );
    }

    /* =========================================================
     * HTTP HELPERS
     * ========================================================= */

    public function get(
        string $endpoint,
        array $data = []
    ): NextcloudApiResponse {

        return $this->request(
            'GET',
            $endpoint,
            $data
        );
    }

    public function post(
        string $endpoint,
        array $data = []
    ): NextcloudApiResponse {

        return $this->request(
            'POST',
            $endpoint,
            $data
        );
    }

    public function put(
        string $endpoint,
        array $data = []
    ): NextcloudApiResponse {

        return $this->request(
            'PUT',
            $endpoint,
            $data
        );
    }

    public function delete(
        string $endpoint,
        array $data = []
    ): NextcloudApiResponse {

        return $this->request(
            'DELETE',
            $endpoint,
            $data
        );
    }

    /* =========================================================
     * USERS
     * ========================================================= */

    public function getCurrentUser(): NextcloudApiResponse
    {
        return $this->get(
            '/ocs/v2.php/cloud/user'
        );
    }

    public function getUsers(): NextcloudApiResponse
    {
        return $this->get(
            '/ocs/v2.php/cloud/users'
        );
    }

    public function getUser(
        string $userId
    ): NextcloudApiResponse {

        return $this->get(
            '/ocs/v2.php/cloud/users/'.
            urlencode($userId)
        );
    }

    public function createUser(
        string $userId,
        ?string $email = null,
        ?string $password = null
    ): NextcloudApiResponse {

        return $this->post(
            '/ocs/v2.php/cloud/users',
            [
                'userid' => $userId,
                'email' => $email,
                'password' => $password,
            ]
        );
    }

    /* =========================================================
     * SYSTEM
     * ========================================================= */

    public function getServerInfo(): NextcloudApiResponse
    {
        return $this->get(
            '/ocs/v2.php/apps/serverinfo/api/v1/info'
        );
    }

    public function getCapabilities(): NextcloudApiResponse
    {
        return $this->get(
            '/ocs/v2.php/cloud/capabilities'
        );
    }

    public function getStatus(): NextcloudApiResponse
    {
        return $this->get(
            'status.php'
        );
    }
}
