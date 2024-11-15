<?php
namespace App\Framework;
/*
$test = 5;
$result = (new Validator($test))
    ->required()
    ->match('/\d/', 'not_a_number')
    ->url('not_a_link')
    ->custom(fn($value): bool => $value === 3, 'not_a_three')
    ->min(4)
    ->max(4)
    ->equals(4, 'must_be_a_four');

dd($result->isCorrect(), $result->getErrors());
*/
class Validator
{
    protected bool $isCorrect = true;

    protected array $errors = [];

    protected mixed $field;

    public function __construct(mixed $field = null)
    {
        $this->field = $field;
    }

    public function setField(mixed $field): static
    {
        $this->field = $field;
        return $this;
    }
    
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function required(?string $errorName = null): static
    {
        if(is_null($this->field)){
            $this->isCorrect = false;
            $this->errors[] = 'required';
        }

        return $this;
    }


    public function populated(?string $errorName = null): static
    {
        if(empty($this->field)){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'populated';
        }

        return $this;
    }

    public function int(?string $errorName = null): static
    {
        if(!is_int($this->field)){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'int';
        }

        return $this;
    }

    public function bool(?string $errorName = null): static
    {
        if(!is_bool($this->field)){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'bool';
        }

        return $this;
    }

    public function float(?string $errorName = null): static
    {
        if(!is_float($this->field)){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'float';
        }

        return $this;
    }

    public function numeric(?string $errorName = null): static
    {
        if(!is_numeric($this->field)){
            $this->isCorrect = false;
            $this->errors[] = 'numeric';
            $this->errors[] = $errorName ? $errorName : 'numeric';
        }

        return $this;
    }

    public function string(?string $errorName = null): static
    {
        if(!is_string($this->field)){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'string';
        }

        return $this;
    }

    public function max(int|float $value, ?string $errorName = null): static
    {
        if($this->field > $value){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'max';
        }

        return $this;
    }

    public function min(int|float $value, ?string $errorName = null): static
    {
        if($this->field < $value){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'min';
        }

        return $this;
    }

    public function equals(mixed $value, ?string $errorName = null): static
    {
        if($this->field != $value){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'equals';
        }

        return $this;
    }
    public function array(array $value, ?string $errorName = null): static
    {
        if(!is_array($value)){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'array';
        }

        return $this;
    }

    public function match(string $value, ?string $errorName = null): static
    {
        if(!preg_match($value, (string) $this->field)){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'match';
        }

        return $this;
    }

    public function custom(\Closure $argument, ?string $errorName = null): static
    {
        if(!$argument($this->field)){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'custom';
        }

        return $this;
    }

    public function email(?string $errorName = null): static
    {
        if(!filter_var($this->field, FILTER_VALIDATE_EMAIL)){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'email';
        }

        return $this;
    }

    public function url(?string $errorName = null): static
    {
        if(!filter_var($this->field, FILTER_VALIDATE_URL)){
            $this->isCorrect = false;
            $this->errors[] = $errorName ? $errorName : 'url';
        }

        return $this;
    }

}