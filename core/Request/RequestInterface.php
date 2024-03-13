<?php

namespace Core\Request;

interface RequestInterface
{
    public function get(string $key, string $default = null): mixed;

    public function getMethod(): ?RequestMethod;

    public function getURI(): string;
}