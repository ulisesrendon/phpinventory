<?php
class Validator
{
    private $items;
    private $errores = [];

    public function getErrores(): array
    {
        return $this->errores;
    }

    public function __construct(array $items = [])
    {
        $this->items = $items;

        foreach ($items as $unidad_nombre => $unidad) {
            $unidad_errores = [];
            foreach ($unidad['condiciones'] as $condicion => $condicion_argumento) {

                $es_valido = $this->$condicion($unidad['valor'], $condicion_argumento);
                if (!$es_valido) {
                    $unidad_errores[$condicion] = $condicion;
                }
            }
            if (count($unidad_errores)) {
                $this->errores[$unidad_nombre] = $unidad_errores;
            }
        }
    }

    public static function single($valor, $condicion, $argumento = false)
    {
        if (is_string($condicion)) {
            if (!$argumento)
                $argumento = $condicion;
            $condicion = [$condicion => $argumento];
        }
        $singleValidacion = new self([
            'single' => [
                'valor' => $valor,
                'condiciones' => $condicion,
            ]
        ]);
        $singleErrores = $singleValidacion->getErrores();
        if (count($singleErrores))
            return $singleErrores['single'];
        return [];
    }

    public function empty($valor, $argumento): bool
    {
        return empty($valor);
    }

    public function int($valor, $argumento): bool
    {
        return is_int($valor);
    }

    public function numeric($valor, $argumento): bool
    {
        return is_numeric($valor);
    }

    public function string($valor, $argumento): bool
    {
        return is_string($valor);
    }

    public function max($valor, $argumento): bool
    {
        return $valor <= $argumento;
    }

    public function min($valor, $argumento): bool
    {
        return $valor >= $argumento;
    }

    public function regex($valor, $argumento): bool
    {
        return (bool) preg_match($valor, $argumento);
    }

    public function custom($valor, $argumento): bool
    {
        return (bool) $argumento($valor);
    }

    public function email($valor, $argumento): bool
    {
        return (bool) filter_var($valor, FILTER_VALIDATE_EMAIL);
    }

    public function url($valor, $argumento): bool
    {
        return (bool) filter_var($valor, FILTER_VALIDATE_URL);
    }

}