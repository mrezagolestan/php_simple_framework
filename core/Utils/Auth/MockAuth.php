<?php

namespace Core\Utils\Auth;

class MockAuth implements AuthInterface
{
    private ?int $userId = null;

    public function authenticated(): bool
    {
        return !is_null($this->userId);
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function auth(int $userId)
    {
        $this->userId = $userId;
    }

    public function logout()
    {
        $this->userId = null;
    }

}