<?php

namespace Core\Request;

class Request implements RequestInterface
{
    private ?string $URI = null;
    private ?RequestMethod $method;

    public function __construct()
    {
        $this->setURI();
        $this->setParameters($_GET);
        $this->setParameters($_POST);
        $this->setMethod();
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

    private function setParameters(array $values): void
    {
        foreach ($values as $key => $value) {
            //convert request value to prevent sql injection
            $this->$key = htmlspecialchars($value);
        }
    }


    private function setMethod(): void
    {
        $this->method = RequestMethod::from($_SERVER['REQUEST_METHOD']);
    }


    private function setURI(): void
    {
        //remove query string
        $this->URI = explode('?', $_SERVER["REQUEST_URI"])[0];
    }
}