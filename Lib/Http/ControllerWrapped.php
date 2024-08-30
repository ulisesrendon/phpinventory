<?php
namespace Lib\Http;

use DomainException;
use ReflectionMethod;
use ReflectionFunction;
use Lib\Http\ResponseRender;
use Lib\Http\Contracts\RequestState;
use Lib\Http\Contracts\ResponseState;
use Lib\Http\Contracts\ControllerWrapper;
use Lib\Http\Exception\InvalidControllerException;

class ControllerWrapped implements ControllerWrapper
{
    protected null|array|object $Controller;

    protected string $method;
    
    protected string $path;
    
    protected array $params;

    public function __construct(
        null|array|object $Controller,
        RequestState $RequestState,
        array $RouteParams = [],
    )
    {
        if (
            is_array($Controller) && (!class_exists($Controller[0]) || !method_exists($Controller[0], $Controller[1]))
            || is_object($Controller) && !is_callable($Controller)
        ) {
            throw new InvalidControllerException('Route controller is not a valid callable or it can not be called from the actual scope');
        }

        if (is_array($Controller)) {
            $Controller = [new $Controller[0], $Controller[1]];
        }

        $this->method = $RequestState->getMethod();
        $this->path = $RequestState->getPath();
        $this->params = $this->resolveParams($Controller, $RequestState, $RouteParams);
        $this->Controller = $Controller;
    }

    public function getResponse(): ?ResponseState
    {
        ob_start();
        $Result = call_user_func_array($this->Controller, $this->params);
        ob_clean();

        $ResultType = gettype($Result);

        if( 'object' === $ResultType && $Result instanceof ResponseState){
            $Result->setParams($this->params);
            $Result->setMethod($this->method);
            $Result->setPath($this->path);
            return $Result;
        }else if (
            is_scalar($Result) 
            || ( 'object' === $ResultType && $Result instanceof Stringable)
        ) {
            $status = empty($Result) ? 204: 200;
            $body = (string) $Result;

            return new ResponseRender($body, $status);
        }

        return null;
    }

    protected function resolveParams($Controller, RequestState $RequestState, $RouteParams): array
    {
        if (gettype($Controller) == 'object' && get_class($Controller) == 'Closure') {
            $reflection = new ReflectionFunction($Controller);
        } else {
            $reflection = new ReflectionMethod(...$Controller);
        }

        $params = [];
        foreach ($reflection->getParameters() as $parameter) {
            $paramName = $parameter->getName();

            // Request state  injection
            if ($parameter->getType()?->getName() === get_class($RequestState)) {
                $params[$paramName] = $RequestState;
                continue;
            }

            if (!isset($RouteParams[$paramName])) {
                throw new DomainException("Cannot resolve the parameter: '{$paramName}'");
            }

            $params[$paramName] = $RouteParams[$paramName];
        }

        return $params;
    }
}