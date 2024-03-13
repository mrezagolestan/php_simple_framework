<?php

namespace Core\Utils;

class Hash
{

    public static function make(string $plain): string
    {
        return password_hash($plain, PASSWORD_BCRYPT);
    }

    public static function check($plain, $hash): bool
    {
        return password_verify($plain, $hash);
    }

}