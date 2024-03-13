<?php

namespace Core\Utils\Auth;

class Auth implements AuthInterface
{
    public function authenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function getUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public function auth(int $userId)
    {
        $_SESSION['user_id'] = $userId;
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
    }

}