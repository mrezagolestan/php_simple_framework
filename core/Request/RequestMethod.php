<?php

namespace Core\Request;

enum RequestMethod
{
    case GET;
    case POST;

    public static function from(string $value): RequestMethod
    {
        foreach (self::cases() as $case) {
            if ($case->name == $value) {
                return $case;
            }
        }
        throw new \ValueError("$value is not a valid backing value for enum " . self::class);
    }

}