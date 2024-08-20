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