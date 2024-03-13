<?php

namespace Core\Request;

class MockRequest implements RequestInterface
{
    private ?string $URI = null;
    private ?RequestMethod $method;

    public function __construct()
    {

    }

    public function get(string $key, string $default = null): mixed
    {
        return $this->$key ?? $default;
    }

    public function getMethod(): ?RequestMethod
    {
        return $this->method ?? null;
    }

    public function getURI(): string
    {
        if (!$this->URI) {
            $this->setURI();
        }
        return $this->URI;
    }

    public function setParameters(array $values): void
    {
        foreach ($values as $key => $value) {
            //convert request value to prevent sql injection
            $this->$key = htmlspecialchars($value);
        }
    }


    public function setMethod(RequestMethod $method): void
    {
        $this->method = $method;
    }


    public function setURI($uri): void
    {
        $this->URI = $uri;
    }
}