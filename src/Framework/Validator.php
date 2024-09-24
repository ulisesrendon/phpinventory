<?php
namespace App\Framework;
class Validator
{
    private $items;
    private $errors = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;

        foreach ($items as $field => ['value' => $value, 'conditions' => $conditions]) {
            $fieldErrors = [];
            foreach ($conditions as $condition => $argument) {
                $is_valid = $this->$condition($value, $argument);
                if (!$is_valid) {
                    $fieldErrors[$condition] = $condition;
                }
            }
            if (count($fieldErrors)) {
                $this->errors[$field] = $fieldErrors;
            }
        }
    }

    public function getErrores(): array
    {
        return $this->errors;
    }

    public static function single($value, $condition, $argument = false)
    {
        if (is_string($condition)) {
            if (!$argument)
                $argument = $condition;
            $condition = [$condition => $argument];
        }
        $singleValidacion = new self([
            'single' => [
                'valor' => $value,
                'condiciones' => $condition,
            ]
        ]);
        $singleErrores = $singleValidacion->getErrores();
        if (count($singleErrores))
            return $singleErrores['single'];
        return [];
    }

    public function empty($value, $argument): bool
    {
        return empty($value);
    }

    public function int($value, $argument): bool
    {
        return is_int($value);
    }

    public function numeric($value, $argument): bool
    {
        return is_numeric($value);
    }

    public function string($value, $argument): bool
    {
        return is_string($value);
    }

    public function max($value, $argument): bool
    {
        return $value <= $argument;
    }

    public function min($value, $argument): bool
    {
        return $value >= $argument;
    }

    public function regex($value, $argument): bool
    {
        return (bool) preg_match($value, $argument);
    }

    public function custom($value, $argument): bool
    {
        return (bool) $argument($value);
    }

    public function email($value, $argument): bool
    {
        return (bool) filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function url($value, $argument): bool
    {
        return (bool) filter_var($value, FILTER_VALIDATE_URL);
    }

}