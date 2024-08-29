<?php
namespace Lib\Http;

use DomainException;
use ReflectionMethod;
use Lib\Http\Response;
use ReflectionFunction;
use Lib\Http\Helper\RequestData;
use Lib\Http\Contracts\RequestState;
use Lib\Http\Contracts\ResponseState;
use Lib\Http\Contracts\ControllerWrapper;
use Lib\Http\Exception\InvalidControllerException;

class ControllerWrapped implements ControllerWrapper
{
    protected null|array|object $Controller;
    protected array $Params;

    protected int $status;

    protected string $body;
    
    protected array $headers;

    protected string $method;

    protected string $path;

    protected bool $called = false;

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
        $this->Params = $this->resolveParams($Controller, $RequestState, $RouteParams);

        $this->Controller = $Controller;
    }
    public function response()
    {
        $this->called = true;

        ob_start();
        $Result = call_user_func_array($this->Controller, $this->Params);
        ob_clean();

        $ResultType = gettype($Result);

        if( 'object' === $ResultType && $Result instanceof ResponseState){
            $this->status = $Result->getStatus();
            $this->body = $Result->getBody();
            $this->headers = $Result->getHeaders();
        }else if (
            is_scalar($Result) 
            || ( 'object' === $ResultType && $Result instanceof Stringable)
        ) {
            $this->status = empty($Result) ? 204: 200;
            $this->body = (string) $Result;
            $this->headers = [];
        }

        return $this;
    }

    public function getStatus(): int
    {
        if(false === $this->called){
            $this->response();
        }

        return $this->status;
    }

    public function getBody(): string
    {
        if (false === $this->called) {
            $this->response();
        }

        return $this->body;
    }

    public function getHeaders(): array
    {
        if (false === $this->called) {
            $this->response();
        }

        return $this->headers;
    }

    public function getController(): null|array|object
    {
        return $this->Controller;
    }

    public function getParams(): array
    {
        return $this->Params;
    }

    public function isCalled(): bool
    {
        return $this->called;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setUpStatus()
    {
        http_response_code($this->status);
    }

    public function setUpHeaders()
    {
        foreach ($this->headers as $header) {
            header($header);
        }
    }

    protected function resolveParams($Controller, RequestData $RequestData, $RouteParams): array
    {
        if (gettype($Controller) == 'object' && get_class($Controller) == 'Closure') {
            $reflection = new ReflectionFunction($Controller);
        } else {
            $reflection = new ReflectionMethod(...$Controller);
        }

        $params = [];
        foreach ($reflection->getParameters() as $parameter) {
            $paramName = $parameter->getName();
            // Request data object injection
            if ($parameter->getType()?->getName() === get_class($RequestData)) {
                $params[$paramName] = $RequestData;

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