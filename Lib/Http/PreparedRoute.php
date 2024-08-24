<?php
namespace Lib\Http;

use Stringable;
use Lib\Http\Exception\InvalidControllerException;

class PreparedRoute implements Stringable
{
    public null|array|object $Controller;
    public array $Params;

    public function __construct(null|array|object $Controller, array $Params = [])
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

        $this->Controller = $Controller;
        $this->Params = $Params;
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
}