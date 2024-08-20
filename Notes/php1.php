## Operadores Aritméticos

Los operadores aritméticos en PHP permiten realizar operaciones matemáticas básicas sobre valores númericos y son los siguientes:

- **Suma (+)**: Suma dos valores. Ejemplo: `$a + $b`.
- **Resta (-)**: Resta un valor de otro. Ejemplo: `$a - $b`.
- **Multiplicación (*)**: Multiplica dos valores. Ejemplo: `$a * $b`.
- **División (/)**: Divide un valor por otro. Ejemplo: `$a / $b`.
- **Potenciación (\**)**: Eleva a un valor a la potencia de otro. Ejemplo: `$a**$b`.
- **Módulo (%)**: Devuelve el residuo de una división. Ejemplo: `$a % $b`.

Ejemplo de uso de los operadores aritmeticos:

```php
$a = 10;
$b = 3;

echo $a + $b;  // 10 + 3 = 13
echo $a - $b;  // 10 - 3 = 7
echo $a * $b;  // 10 * 3 = 30
echo $a / $b;  // 10 / 3 = 3.3333
echo $a ** $b;  // 10**3 = 1000
echo $a % $b;  // 10 % 3 = 1 (Diez dividido entre tres es igual a 3 y resta 1)

```

## Operadores de Asignación

Los operadores de asignación se utilizan para asignar valores a las variables y ya vimos el operador de asignación más básico, el signo "igual que" (=), pero en PHP este operador se puede combinar con los operadores aritmeticos para realizar alguna operación matematica y en automatico asignar el resultado a una variable.

- **Asignación simple (=)**: Asigna un valor a una variable. Ejemplo: `$a = 10`.
- **Adición y asignación (+=)**: Suma y asigna el resultado. Ejemplo: `$a += 5` es equivalente a `$a = $a + 5`.
- **Sustracción y asignación (-=)**: Resta y asigna el resultado. Ejemplo: `$a -= 3` es equivalente a `$a = $a - 3`.
- **Multiplicación y asignación (*=)**: Multiplica y asigna el resultado. Ejemplo: `$a *= 2` es equivalente a `$a = $a * 2`.
- **División y asignación (/=)**: Divide y asigna el resultado. Ejemplo: `$a /= 4` es equivalente a `$a = $a / 4`.
- **Potenciación y asignación (\**=)**: Eleva y asigna el resultado. Ejemplo: `$a **= 3` es equivalente a `$a = $a ** 3`.
- **Modulo y asignación (%=)**: Divide y asigna el resuduo resultante. Ejemplo: `$a %= 3` es equivalente a `$a = $a % 3`.

Estos operadores de asignación hacen que el código sea más conciso y fácil de leer.

Ejemplo:

```php
$a = 5;
$a += 3;  // $a es ahora 8
$a -= 2;  // $a es ahora 6
$a *= 4;  // $a es ahora 24
$a /= 6;  // $a es ahora 4
$a %= 3;  // $a es ahora 1

```
Tambien tenemos los operadores abreviados para incremento y decremento, estos operadores premiten de una forma resumida sumar o restar una unidad a un valor y al mismo tiempo asignarlo a la variable.
Los operadores serián los siguientes:

- **$a++**: Suma uno a una variable. Equivallente a: `$a = $a + 1`.
- **$a--**: Resta uno a una variable. Equivallente a: `$a = $a -1`.

```php
$a = 5;

$a++;  // $a es ahora 6
$a--;  // $a vuelve a valer 5
```

### Operadores para cadenas de texto
PHP tiene solo dos operadores para texto, uno para unir cadenas (concatenación) y otro para de forma abreviada unir una cadena a una variable previa y asignar el resultado final.

- **Concatenación (`.`)**: Une dos cadenas de texto.
- **Concatenación y asignación (`.=`)**: Une una cadena a otra cadena previamente definida y asigna el resultado.

Ejemplo:


```php
$message = 'Hola';
$user = 'Luis';

echo $message . ' ' . $user; // Hola Luis

$message .= ' ' . $user;
echo $message; // Hola Luis
```
Hay que notar que por cada cadena de texto que se quiere concatenar también se concatena un espacio para que las palabras no queden juntas.

Hay otra forma de concatenar cadenas y otros valores sin el operador punto:

```php
echo "{$message} {$user}"; // Hola Luis
```

Para usar este metodo es necesario usar comillas simples, y luego entre llaves se indica el valor a concatenar, puede ser cualquier valor escalar aunque no sea una cadena de texto, pero hay que tener en cuenta que ese valor sera convertido a texto de forma dinamica y que hay que tener cuidado con valores booleanos o nulos.

Al intentar imprimir un valor booleano verdadero este sera convertido a 1, pero al intentar imprimir un valor falso o el valor null, estos no imprimirán nada.


## Operadores de comparacion y operadores logicos

Estos operadores nos permitiran crear programas que puedan tomar desiciones en base a los valores que proporcionemos y controlar el flujo de los datos hacia los algoritmos correspondientes y ejecutar solo las instrucciones correspondientes.

### Operadores de Comparación

Estos operadores se utilizan para comparar dos valores y nos da como resultado un valor que puede ser verdadero ó falso, los operadores son los siguientes:

- **Igual (`==`)**: Verifica si dos valores son iguales.
- **Idéntico (`===`)**: Verifica si dos valores son iguales y del mismo tipo.
- **Diferente (`!=` o `<>`)**: Verifica si dos valores son diferentes.
- **No idéntico (`!==`)**: Verifica si dos valores no son iguales o no son del mismo tipo.
- **Mayor que (`>`)**: Verifica si un valor es mayor que otro.
- **Menor que (`<`)**: Verifica si un valor es menor que otro.
- **Mayor o igual que (`>=`)**: Verifica si un valor es mayor o igual que otro.
- **Menor o igual que (`<=`)**: Verifica si un valor es menor o igual que otro.

Ejemplo:

```php
$a = 5;
$b = 10;

var_dump( $a == $b );  // Cinco es igual a diez? Falso
var_dump( $a === $b ); // Cinco es igual a diez y del mismo tipo? Falso
var_dump( $a != $b );  // Cinco es diferente de 10? Verdadero
var_dump( $a !== $b ); // Cinco es diferente de 10 ó de diferente tipo? Verdadero
var_dump( $a > $b );   // Cinco es mayor que diez? Falso
var_dump( $a < $b );   // Cinco es menor que diez? Verdadero
var_dump( $a >= $b );  // Cinco es mayor o igual que diez? Falso
var_dump( $a <= $b );  // Cinco es menor o igual que diez? verdadero

```

var_dump() es una herramienta que nos de PHP para depurar (identificar y corregir problemas, en ingles se le conoce como Debugging), permite imprimir información el tipo y valor de un dato o variable, solo es necesario escribir var_dump y entre parentesis escribir el valor a inspeccionar.


### Operadores Lógicos

Los operadores logicos se utilizan para combinar datos booleanos y dependiendo de los valores previos y el tipo de operador usado daran como resultado un valor verdadero o falso.

- **AND (`&&`)**: Verdadero si ambas declaraciones son verdaderas.
- **OR (`||`)**: Verdadero si al menos una de las declaraciones es verdadera.
- OR Excluyente (`XOR`) : Verdadero si solo una de las dos declaraciones es verdadera.

Ejemplo:

```php
$a = true;
$b = false;

var_dump($a && $b);  // bool(false)
var_dump($a || $b);  // bool(true)
var_dump($a XOR $b);  // bool(true)


### Operador lógico de negación
- **Negación (`!`)**: Invierte un valor booleano, la declaración será verdadera solo si el valor previo era falso.

Ejemplo:

```php
$a = true;
$b = false;

var_dump(!$a);       // bool(false)
var_dump(!$b);       // bool(true)
```

Si el valor previo a ser negado no era booleano este será convertido a booleano y luego será negado, ejemplo:

```php
$a = '';
$b = 5;
$c = 0;
$d = 'Hola';
$e = null;
$f = -1;

var_dump(!$a);       // bool(true)
var_dump(!$b);       // bool(false)
var_dump(!$c);       // bool(true)
var_dump(!$d);       // bool(false)
var_dump(!$e);       // bool(true)
var_dump(!$f);       // bool(false)
```
Los valores que sean considerados vacios serán evaluados como el valor booleano false, entre estos valores vaciós podemos encontrar el número cero 0, una cadena de texto vacia '', el valor nulo null, un arreglo de datos vacio, etc. Cualquier otro valor será evaluado como verdadero, por lo que hay que tener cuidado, ya que incluso los valores númericos negativos serán evaluados como verdaderos.

El operador de negación puede ser usado dos veces en el mismo valor, y lo que básicamente harás esta operación sera convertir cualquier valor de cualquier otro tipo en un valor booleano, aunque si el valor ya era booleano este se mantendrá intacto.

Ejemplo:

```php
$a = '';
$b = true;

var_dump(!!$a);       // bool(false)
var_dump(!!$b);       // bool(true)
```

### Operador de fusión de nulos

El operador de fusión de nulos (Nullish coalescense operator) funciona con dos valores y permite evaluar si el primer valor dado es nulo, en caso de que no sea nulo, retornara ese valor, en caso de que el primer valor sea nulo, el operador retornara el segundo dato, sea cual sea su valor.

Ejemplo:

```php
$message = null;
$defaultMessage = 'Buenos días';

echo $message ?? $defaultMessage; // Buenos días
```
Este operador incluso variables que no existan (evaluandolas como el valor nulo), por lo que es muy útil para comprobar datos y asignar valores por defecto.

Ejemplo:

```php
$message = $message ?? 'Buenos días';

echo $message; // Buenos días
```
En este ejemplo la variable message no existe previamente, por lo que usando el operador ?? podemos definir un valor por defecto, y cuando la variable si exista, pues en ese caso sera su valor el que se asignara.

Este operador también cuenta con su forma abreviada de asignación, por lo que el código anterior puede quedar de la siguiente manera:

```php
$message ??= 'Buenos días';
echo $message; // Buenos días
```
Este operador se puede usar mas de una vez en la misma sentencia, permitiendo evaluar multiples datos, hasta encontrar alguno que no sea nulo para retornarlo, o de lo contrario retornara el ultimo valor dado, ejemplo:

```php
$messageDefault = 'Buenos días';
echo $message1 ?? $message2 ?? $message3 ?? $messageDefault; // Buenos días
```
### Operador ternario

Este operador es similar al anterior, pero solo funciona con variables definidas, acepta hasta 3 datos, uno para evaluar y dos para ser retornados.
El operador ternario evalua si el primer valor dado es verdadero o falso, si es verdadero el operador retorna el primer valor disponible para retorno, si no lo es retorna el ultimo valor, ejemplo:

```php
$age = 12;
$message = $age < 18 ? 'Eres menor de edad' : 'Eres mayor de edad';
```