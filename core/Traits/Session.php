<?php

namespace Core\Traits;

trait Session
{
    public function loadSession()
    {
        session_start();
    }
}