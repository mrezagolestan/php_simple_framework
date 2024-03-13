<?php

namespace Core;

use ReflectionClass;
use Core\Traits\Config;
use Core\Traits\Env;
use Core\Traits\Session;

class Application
{
    use Config, Env, Session;

    private array $bindings = [];

    private array $singletons = [];

    protected static ?Application $instance = null;

    protected function __construct()
    {
        $this->loadEnv();
        $this->loadConfig();
        $this->loadSession();
    }

    public static function getInstance(): Application
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function bindFromKernelConfig(string $type)
    {
        $bindingList = require APP_DIR . 'kernel.php';

        foreach ($bindingList[$type] as $binding) {
            if (isset($binding[2]) && $binding[2] == true) {
                app()->singleton($binding[0], $binding[1]);

            } else {
                app()->bind($binding[0], $binding[1]);

            }
        }
    }

    public function terminateFromKernelConfig(string $type)
    {
        $bindingList = require APP_DIR . 'kernel.php';

        $terminationCallback = $bindingList['termination_scripts'][$type];

        $terminationCallback();
    }

    public function singleton($abstract, $concrete)
    {
        if (is_callable($concrete)) {
            $instance = call_user_func($concrete);
        } else {
            $instance = new $concrete;
        }

        $this->singletons[$abstract] = &$instance;
    }

    public function bind($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function resolve($abstract)
    {
        if (isset($this->singletons[$abstract])) {
            return $this->singletons[$abstract];
        }

        if (!isset($this->bindings[$abstract])) {
            $this->ensureClassIsInstantiable($abstract);
        }

        $concrete = $this->bindings[$abstract] ?? $abstract;

        if (is_callable($concrete)) {
            return call_user_func($concrete);
        }

        return $this->buildInstance($concrete);
    }

    protected function ensureClassIsInstantiable($class)
    {
        $reflection = new ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new \Exception("{$class} is not instantiable");
        }
    }

    public function buildInstance($class)
    {
        if (isset($this->singletons[$class])) {
            return $this->singletons[$class];
        }

        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if (isset($this->bindings[$class]) && is_callable($this->bindings[$class])) {
            return call_user_func($this->bindings[$class]);
        }

        //-------------------- without Dependency ------------------
        if (!$constructor && $reflection->isInstantiable()) {
            return new $class;
        }

        if (!$constructor && isset($this->bindings[$class])) {
            $class = $this->bindings[$class];

            return $this->buildInstance($class);
        }

        if (!$constructor && !isset($this->bindings[$class])) {
            throw new \Exception("{$class} is not instantiable");
        }

        //-------------------- With Dependency ------------------

        $parameters = $constructor->getParameters();

        $parameterInstances = [];


        foreach ($parameters as $parameter) {
            if (!$parameter->getType() && !$parameter->isOptional()) {
                throw new \Exception("{$parameter->getName()}  for class {$class} is not instantiable");
            }

            $parameterInstances[] = $this->buildInstance($parameter->getType()->getName());
        }

        return new $class(...$parameterInstances);
    }
}