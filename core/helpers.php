<?php

use Core\Application;

if (!function_exists('app')) {
    /**
     * Get the App Instance
     *
     * @return Application
     */
    function app(): Application
    {
        return Application::getInstance();
    }
}
if (!function_exists('view')) {
    function view($name, $values = []): \Core\Response\ResponseInterface
    {
        foreach ($values as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include APP_DIR . 'views/' . $name . '.php';
        $result = ob_get_contents();
        ob_end_clean();

        $response = app()->resolve(\Core\Response\ResponseInterface::class);
        $response->setBody($result);
        return $response;
    }
}

if (!function_exists('include')) {
    function includeView($name)
    {
        require APP_DIR . 'views/' . $name . '.php';
    }
}

if (!function_exists('sectionStart')) {
    function sectionStart()
    {
        ob_start();
    }
}

if (!function_exists('sectionEnd')) {
    function sectionEnd($name)
    {
        global $$name;
        $$name = ob_get_contents();
        ob_end_clean();
    }
}
if (!function_exists('sectionGet')) {
    function sectionGet($name)
    {
        global $$name;
        echo $$name;
    }
}

if (!function_exists('response')) {
    function response(string $body, int $status = 200): \Core\Response\ResponseInterface
    {
        return app()
            ->resolve(\Core\Response\ResponseInterface::class)
            ->setBody($body)
            ->setStatus($status);
    }
}


if (!function_exists('redirect')) {
    function redirect(string $to)
    {
        return app()
            ->resolve(\Core\Response\ResponseInterface::class)
            ->setBody($to)
            ->setStatus(302);
    }
}

if (!function_exists('layout')) {
    function layout($name)
    {
        require APP_DIR . 'views/layout/' . $name . '.php';

    }
}

if (!function_exists('setFlashMessage')) {
    function setFlashMessage(string $type, string $message)
    {
        $_SESSION['flash_message'] = ['type' => $type, 'message' => $message];
    }
}

if (!function_exists('getFlashMessage')) {
    function getFlashMessage(): ?array
    {
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $message;
        } else {
            return null;
        }
    }
}

if (!function_exists('dd')) {
    function dd(mixed ...$vars): never
    {
        die(\PHP_SAPI);
        if (!\in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true) && !headers_sent()) {
            header('HTTP/1.1 500 Internal Server Error');
        }

        if (array_key_exists(0, $vars) && 1 === count($vars)) {
            VarDumper::dump($vars[0]);
        } else {
            foreach ($vars as $k => $v) {
                VarDumper::dump($v, is_int($k) ? 1 + $k : $k);
            }
        }

        exit(1);
    }
}

if (!function_exists('config')) {
    function config()
    {
        global $config;
        return $config;
    }
}

if (!function_exists('env')) {
    function env(string $key)
    {
        return $_ENV[$key];
    }
}







