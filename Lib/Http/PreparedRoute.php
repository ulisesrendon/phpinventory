<?php
namespace Lib\Http;

use Stringable;
use Lib\Http\Route;
use DomainException;
use ReflectionMethod;
use ReflectionFunction;
use Lib\Http\Helper\RequestData; 
use Lib\Http\Exception\InvalidControllerException;

class PreparedRoute implements Stringable
{
    public null|array|object $Controller;
    public RequestData $RequestData;
    public array $RouteParams;
    public array $Params;

    public function __construct(Route $Route, RequestData $RequestData)
    {
        $this->RequestData = $RequestData;
        $this->Controller = $Route->getController($this->RequestData->method);
        $this->RouteParams = $Route->bindParams($RequestData->uri);
        $this->Params = $this->resolveParams();
    }

    public function __toString(): string
    {      
        return (string) $this->execute();
    }

    public function execute(): string
    {
        ob_start();        
        $ControllerResult = call_user_func_array($this->Controller, $this->Params);
        if( is_scalar($ControllerResult) || ('object' === gettype($ControllerResult) && $ControllerResult instanceof Stringable ) ){
            echo $ControllerResult;
        }
        
        return (string) ob_get_clean();
    }

    public function resolveParams(): array
    {
        if ('object' == gettype($this->Controller) && 'Closure' == get_class($this->Controller)) {
            $reflection = new ReflectionFunction($this->Controller);
        } else {
            $reflection = new ReflectionMethod(...$this->Controller);
        }

        $params = [];
        foreach ($reflection->getParameters() as $parameter) {
            $paramName = $parameter->getName();
            // Request data object injection
            if ($parameter->getType()?->getName() === get_class($this->RequestData)) {
                $params[$paramName] = $this->RequestData;
                continue;
            }

            if (!isset($this->RouteParams[$paramName])) {
                throw new DomainException("Cannot resolve the parameter: '{$paramName}'");
            }

            $params[$paramName] = $this->RouteParams[$paramName];
        }

        return $params;
    }
}