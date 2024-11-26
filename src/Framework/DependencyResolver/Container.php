<?php

namespace App\Framework\DependencyResolver;

use App\Framework\DependencyResolver\NotFoundException;
use App\Framework\DependencyResolver\ContainerException;

final class Container
{
    /** @var array<class-string,mixed> */
    private array $container;

    private static ?object $Instance = null;

    /**
     * Summary of resolve
     * @param class-string $className
     * @throws ContainerException|NotFoundException
     * @return object
     */
    public function resolve(string $className): object
    {
        try{
            $reflectionClass = new \ReflectionClass($className);
        }catch(\Exception $e ){
            throw new NotFoundException($e->getMessage());
        }

        $constructor = $reflectionClass->getConstructor();

        # If constructor is empty, we can do a `new $className()`
        if (null === $constructor) {
            return $reflectionClass->newInstance();
        }

        # If not empty, let's resolve the class dependencies
        $dependencies = [];
        foreach ($constructor->getParameters() as $parameter) {
            $paramName = $parameter->getType()?->getName();
            if(!is_null($paramName)){
                $dependencies[] = $this->container[$paramName] ?? $this->resolve($paramName); # 🌀 Recursion
            }else{
                $dependencies[] = null;
            }
        }

        # Finally, we store in the container the resolved class
        $class = $reflectionClass->newInstanceArgs($dependencies);
        $this->container[$className] = $class;

        return $class;

    }

    /**
     * Summary of add
     * @template T
     * @param class-string $className
     * @param object<T> $instance
     * @throws ContainerException
     * @return object<T>
     */
    public static function add(string $className, object $instance)
    {
        if (is_null(self::$Instance)) {
            self::$Instance = new self;
        }

        if(isset(self::$Instance->container[$className])){
            throw new ContainerException('Dependency already exists');
        }

        self::$Instance->container[$className] = $instance;

        return self::$Instance->container[$className];
    }

    /**
     * Summary of get
     * @template T
     * @param class-string<T> $className
     * @throws NotFoundException
     * @return T
     */
    public static function get(string $className): object
    {
        if(is_null(self::$Instance)){
            self::$Instance = new self;
        }

        if(!self::has($className)){
            self::$Instance->resolve($className);
        }

        if(is_null(self::$Instance->container[$className])){
            throw new NotFoundException;
        }

        return self::$Instance->container[$className];
    }

    public static function has(string $className): bool
    {
        return isset(self::$Instance->container[$className]);
    }
}
