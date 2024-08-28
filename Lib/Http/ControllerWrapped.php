<?php
namespace Lib\Http;

use DomainException;
use ReflectionMethod;
use ReflectionFunction;
use Lib\Http\Helper\RequestData;
use Lib\Http\Contracts\RequestState;
use Lib\Http\Contracts\ControllerWrapper;
use Lib\Http\Exception\InvalidControllerException;

class ControllerWrapped implements ControllerWrapper
{
    protected null|array|object $Controller;
    protected array $Params;

    public function __construct(
        null|array|object $Controller,
        RequestState $RequestState,
        string $regexp,
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

        $RouteParams = $this->bindParams($RequestState->getPath(), $regexp);
        $this->Params = $this->resolveParams($Controller, $RequestState, $RouteParams);

        $this->Controller = $Controller;
    }

    public function get()
    {

    }

    public function execute(): string
    {
        ob_start();
        $ControllerResult = call_user_func_array($this->Controller, $this->Params);
        if (is_scalar($ControllerResult) || (gettype($ControllerResult) === 'object' && $ControllerResult instanceof Stringable)) {
            echo $ControllerResult;
        }

        return (string) ob_get_clean();
    }

    public function bindParams(string $path, string $regexp): array
    {
        preg_match_all('/:([a-zA-Z0-9]+)/', $path, $paramNames, PREG_SET_ORDER);
        $paramNames = array_column($paramNames, 1);

        preg_match($regexp, $path, $uriParams);
        array_shift($uriParams);

        return array_combine($paramNames, $uriParams);
    }

    public function resolveParams($Controller, RequestData $RequestData, $RouteParams): array
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