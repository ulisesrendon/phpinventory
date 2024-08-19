# Manejo de datos

Los datos son la materia prima que el software y las aplicaciones utilizan para funcionar. 

Se capturan, almacenan y procesan para realizar diversas funciones. Por ejemplo, una aplicación de gestión de inventarios almacena datos sobre productos, cantidades y precios.

Como programador, escribirás código para gestionar estos datos, realizando cálculos, filtros, agrupaciones, ordenamiento y finalmente transformando esos datos, permitiendo que los datos se conviertan en información útil.

> Es crucial validar los datos para asegurar su precisión y consistencia. Además, de implementar medidas de seguridad para proteger que los datos sensibles sean accedidos por personas no autorizadas.
> 

## Los datos viven en la memoría

Cuando ingresamos datos en nuestro software, estos deben ser temporalmente almacenados en la memoría RAM de la computadora donde este corriendo el programa, para luego poder ser leidos por el procesador al realizar las operaciones de nuestra aplicación y finalmente liberar la memoria destruyendo los datos cuando ya no se usen.

Al trabajar con lenguajes de programación como PHP nosotros no tenemos que preocuparnos por todo este procedimiento, ya que el propio motor de PHP es quien se encarga de gestionarlo.

El motor se encargara de gestionar los datos dentro del Hardware, nosotros solo debemos encargarnos de proporcionarle los datos al software y de estar pendientes de no sobrepasar los recursos de la maquina al hacer calculos muy pesados con grandes cantidades de datos.

El motor de PHP también se encargará de quitar de la memoría del sistema los datos que ya no sean necesarios en nuestro programa usando su sitema de recolección de basura.

solo en casos puntuales en los que necesitemos de gran eficiencie seremos nosotros los que tendremos que indicar mediante comandos cuando ya no necesitemos ciertos datos para eliminarlos de la memoria del sistema.

## Tipos de datos

Para poder trabajar con datos e información, es necesario diferenciar y clasificar los datos, ya que según su tipo se almacenarán y gestionaran de forma diferente.

Cuando trabajamos con cantidades numéricas, esperamos poder hacer operaciones aritméticas y comparar los datos para poder ordenarlos de mayor a menor, o viceversa, y si trabajamos con texto, esperamos poder realizar operaciones de búsqueda y reordenar en orden alfabético por ejemplo.

También será necesario diferenciar entre varios subtipos de datos, no es lo mismo trabajar con números enteros que con números decimales por ejemplo, las computadoras internamente funcionan con el sistema binario con unos y ceros y por ello no gestiónan de la misma manera tipos de datos que para nostors son muy similares como los números enteros y los números reales.

A continuación veremos como se clasifican los datos en PHP :

1. **Tipos de Datos Escalares (Un único valor)**:
    - **Enteros (int)**: Representan números enteros, tanto positivos como negativos.
    - **Decimales (float)**: Representan números con decimales.
    - **Cadenas de texto (string)**: Representan secuencias de caracteres alfanumericos, como letras, palabras o textos.
    - **Booleanos (bool)**: Representan un valor que puede ser verdadero (true) o falso (false).
2. **Tipos de Datos Compuestos (Agrupan multiples datos)**:
    - **Arreglos (Array)**: Contienen listas de múltiples valores, organizados en índices numéricos o alfanumericos.
    - **Objetos (object)**: Agrupan y encapsulan diferentes datos relacionados entre sí para crear unidades de datos mas complejos, y estas unidades se pueden usar para crear nuevos tipos de datos, cada uno con sus propias operaciones y comportamiento.
3. **Tipos de Datos Especiales**:
    - **Nulo (NULL)**: Representa un dato desconocido o faltante.
    - **Recurso (resource)**: Referencias a recursos externos, como conexiones a bases de datos o archivos abiertos.

Conociendo y utilizando correctamente los diferentes tipos de datos, podrás desarrollar aplicaciones más eficientes y seguras, ya que podrás asegurarte que los datos en tu aplicación se manejen de manera adecuada según su naturaleza y propósito.

### Variables y constantes
Las variables y las constantes son las herramientas que nos proveen los lenguajes de programación para poder gestionar los datos que nuestro software usará a lo largo de su ejecución.

Se suele decir que son los contenedores de los datos y aunque esto tecnicamente no es así, es una buena abstracción para referirnos a estas herramientas.

PHP es un lenguaje debilmente tipado, por lo que las variables en PHP son dinámicas, lo que significa que no es necesario declarar explícitamente su tipo de dato, PHP asiganara el tipo según el valor que usemos.

### Las Variables

Las variables en PHP son los contenedores que se usan para almacenar datos que pueden cambiar a lo largo de la ejecución de un programa. Aquí hay algunos puntos clave sobre las variables en PHP:

- **Definición**: Las variables se definen con el símbolo `$` seguido del nombre de la variable.
- **Nombre de variables**: Deben comenzar con una letra o un guion bajo (_), seguidos de cualquier número de letras, números o guiones bajos.
- **Asignación de valores**: Usamos el signo `=` "igual que" para asignar un valor a una variable.
- **Cambió de valor**: El valor de una variable puede cambiar tanto su valor como su tipo las veces que sea necesario.

```php
$name = "Juan";
$age = 25;
$isStudent = true;
```

En este ejemplo:

- `$name` es una variable que almacena una cadena de texto (string).
- `$age` es una variable que almacena un número entero (integer).
- `$isStudent` es una variable que almacena un valor booleano (boolean).

### Las constantes en PHP

Las constantes son similares a las variables, pero su valor no puede cambiar una vez que se han definido. Se utilizan para almacenar valores que deben mantener es mismo valor a lo largo de la ejecución del script.

- **Definición**: Se definen usando la función `define()`.
- **Nombre de constantes**: Por convención, se escriben en mayúsculas.
- **Asignación de valores**: Usamos la construcción define("NOMBRE_DE_LA_CONSTANTE", valor); para definir este tipo de valores inmutables.
- **Cambió de valor**: No es posible cambiar el valor una vez definida la constante, si se intenta cambiar el valor o volver a definir la misma constante PHP mostrara mensajes de error.

```php
define("PI", 3.141592);
define("SITE_NAME", "Mi Sitio Web");
```

En este ejemplo:

- `PI` es una constante que almacena el valor del número Pi.
- `SITE_NAME` es una constante que almacena una cadena de texto.

### Ejemplo Completo

Vamos a crear un pequeño programa que haga uso de constantes y diferentes tipos de datos y que haga algunas operaciones simples con ellos.

```php
<?php
define("TAX_FEE", 0.16);

$product = "Laptop";
$price = 12090.99;
$quantity = 2;

$total = $price * $quantity;

echo "Producto: $product\n";
echo "Precio unitario: $$price\n";
echo "Cantidad: $quantity\n";
echo "Total sin impuesto: $$total\n";

$total = $total * (1 + TAX_FEE);
echo "Total con impuesto (16%): $$total\n";
```

En este ejemplo utilizamos varios tipos de datos: cadenas de texto (strings), números decimales (floats) y enteros (integers).
`TAX_FEE` es una constante que reprensenta el porcentaje de impuestos a aplicar y no necesita cambiar a lo largo del programa.
`$product`, `$price`, `$quantity`, `$total` son variables.
- Con los valores númericos $price y $quantity hacemos una multiplicación con el operador * para obtener el total a pagar antes de impuestos y luego hacemos otra multiplicación que incluye el valor TAX_FEE para poder aumentar el precio añadiendo el valor de los impuestos a pagar.

A parte de la suma y la multiplicación, tenemos en PHP muchos otros operadores para realizar tanto operaciones artitmeticas basicas como otro tipo de operaciones con otros valores.

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

Para usar este metodo es necesario usar comillas simples, y luego entre llaves se indica el valor a concatenar, puede ser cualquier valor escalar aunque no sea una cadena de texto, pero hay que tener en cuenta que ese valor sera convertido a texto de forma dinamica.

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

### Operadores Lógicos

Se utilizan para combinar declaraciones condicionales.

- **AND (`&&` o `and`)**: Verdadero si ambas declaraciones son verdaderas.
- **OR (`||` o `or`)**: Verdadero si al menos una de las declaraciones es verdadera.
- **NOT (`!`)**: Invierte el valor de una declaración, por lo que la declaración será verdadera solo si el valor previo era falso.
- XOR : Verdadero si solo una de las declaraciones es verdadera.

Ejemplo:

```php
$a = true;
$b = false;

var_dump($a && $b);  // bool(false)
var_dump($a || $b);  // bool(true)
var_dump(!$a);       // bool(false)
var_dump($a XOR $b);  // bool(true)
```