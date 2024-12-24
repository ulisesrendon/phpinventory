<?php

namespace Stradow\Framework\DependencyResolver;

final class Container
{
    /** @var array<class-string,mixed> */
    private array $container;

    private static ?object $Instance = null;

    /**
     * @param  class-string  $className
     *
     * @throws ContainerException|NotFoundException
     */
    public function resolve(string $className): object
    {
        try {
            $reflectionClass = new \ReflectionClass($className);
        } catch (\Exception $e) {
            throw new NotFoundException($e->getMessage());
        }

        $constructor = $reflectionClass->getConstructor();

        // If constructor is empty, we can do a `new $className()`
        if ($constructor === null) {
            return $reflectionClass->newInstance();
        }

        // If not empty, let's resolve the class dependencies
        $dependencies = [];
        foreach ($constructor->getParameters() as $parameter) {
            $paramName = $parameter->getType()?->getName();
            if (! is_null($paramName)) {
                $dependencies[] = $this->container[$paramName] ?? $this->resolve($paramName); // 🌀 Recursion
            } else {
                $dependencies[] = null;
            }
        }

        // Finally, we store in the container the resolved class
        $class = $reflectionClass->newInstanceArgs($dependencies);
        $this->container[$className] = $class;

        return $class;

    }

    /**
     * @template T of object
     *
     * @param  class-string<T>  $className
     * @param  T  $instance
     * @return T
     *
     * @throws ContainerException
     */
    public static function add(string $className, object $instance): object
    {
        if (is_null(self::$Instance)) {
            self::$Instance = new self;
        }

        if (isset(self::$Instance->container[$className])) {
            throw new ContainerException('Dependency already exists');
        }

        self::$Instance->container[$className] = $instance;

        return self::$Instance->container[$className];
    }

    /**
     * @template T
     *
     * @param  class-string<T>  $className
     * @return T
     *
     * @throws NotFoundException
     */
    public static function get(string $className): object
    {
        if (is_null(self::$Instance)) {
            self::$Instance = new self;
        }

        if (! self::has($className)) {
            self::$Instance->resolve($className);
        }

        if (is_null(self::$Instance->container[$className])) {
            throw new NotFoundException;
        }

        return self::$Instance->container[$className];
    }

    public static function has(string $className): bool
    {
        return isset(self::$Instance->container[$className]);
    }
}
