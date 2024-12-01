<?php

namespace Ivy;

use Exception;
use GUMP;

class Request
{
    protected array $data;
    protected array $files;
    protected mixed $method;
    protected GUMP $validator;

    public function __construct()
    {
        $json = json_decode(file_get_contents('php://input'), true);
        $this->data = array_merge($_REQUEST, $json ?? []);
        $this->files = $_FILES;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->validator = new GUMP();
    }

    /**
     * Get a specific input item from the request.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function input(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Get a specific file from the request.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function file(string $key, mixed $default = null): mixed
    {
        return $this->files[$key] ?? $default;
    }

    /**
     * Get all files from the request.
     *
     * @return array
     */
    public function files(): array
    {
        return $this->files;
    }

    /**
     * Get all the input data from the request.
     *
     * @return array
     */
    public function all(): array
    {
        return array_merge($this->data, $this->files);
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * Check if the request method matches the given method.
     *
     * @param string $method
     * @return bool
     */
    public function isMethod(string $method): bool
    {
        return strtoupper($this->method) === strtoupper($method);
    }

    /**
     * Validate a specific input item from the request.
     *
     * @param string $key
     * @param array $rules
     * @return bool
     * @throws Exception
     */
    public function validateInput(string $key, array $rules): bool
    {
        $data = [$key => $this->input($key)];
        return $this->validator->validate($data, $rules);
    }

    /**
     * Validate all input data from the request.
     *
     * @param array $rules
     * @return bool|array
     * @throws Exception
     */
    public function validate(array $input, array $rules): bool|array
    {
        return $this->validator->validate($input, $rules);
    }

    /**
     * Get validation errors.
     *
     * @return array
     * @throws Exception
     */
    public function errors(): array
    {
        return $this->validator->get_errors_array();
    }
}
