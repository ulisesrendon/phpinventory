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

El motor de PHP también se encargará de quitar de la memoría del sistema los datos que ya no sean necesarios en nuestro programa usando sus sitema de recolección de basura.

solo en casos puntuales en los que necesitemos de gran eficiencie seremos nosotros los que debemos indicar mediante comandos cuando ya no necesitemos ciertos datos para eliminarlos de la memoria del sistema.

## Tipos de datos

Para poder trabajar con datos e información, es necesario diferenciar y clasificar los datos, ya que según su tipo se almacenarán y gestionaran de forma diferente.

Cuando trabajamos con cantidades numéricas, esperamos poder hacer operaciones aritméticas y comparar los datos para poder ordenarlos de mayor a menor, o viceversa, y si trabajamos con texto, esperamos poder realizar operaciones de búsqueda y reordenar en orden alfabético por ejemplo.

También será necesario diferenciar entre varios subtipos de datos, no es lo mismo trabajar con números enteros que con números decimales por ejemplo, las computadoras por su naturaleza internamente funcionan en sistema binario con unos y ceros y por ello no gestiónan de la misma manera los números enteros y los números reales.

A continuación veremos como se clasifican los datos en PHP :

1. **Tipos de Datos Escalares (Un único valor)**:
    - **Enteros (int)**: Representan números enteros, tanto positivos como negativos.
    - **Decimales (float)**: Representan números con decimales.
    - **Cadenas de texto (string)**: Almacenan secuencias de caracteres, como palabras o frases.
    - **Booleanos (bool)**: Representan un valor que puede ser verdadero (true) o falso (false).
2. **Tipos de Datos Compuestos (Agrupan multiples datos)**:
    - **Arreglos (Array)**: Contienen listas de múltiples valores, organizados en índices numéricos o asociativos.
    - **Objetos (object)**: Agrupan y encapsulan diferentes datos relacionados entre sí para crear unidades de datos mas complejos, y estas unidades se pueden usar para crear nuevos tipos de datos, cada uno con sus propias operaciones y comportamiento.
3. **Tipos de Datos Especiales**:
    - **Nulo (NULL)**: Representa un dato desconocido o faltante.
    - **Recurso (resource)**: Referencias a recursos externos, como conexiones a bases de datos o archivos abiertos.

Conociendo y utilizando correctamente estos tipos de datos, podrás desarrollar aplicaciones más eficientes y seguras, ya que podrás asegurarte que los datos en tu aplicación se manejen de manera adecuada según su naturaleza y propósito.

### Variables en PHP

Las variables en PHP son contenedores que se usan para almacenar datos que pueden cambiar a lo largo de la ejecución de un script. Aquí hay algunos puntos clave sobre las variables en PHP:

- **Definición**: Las variables se definen con el símbolo `$` seguido del nombre de la variable.
- **Nombre de variables**: Deben comenzar con una letra o un guion bajo (_), seguidos de cualquier número de letras, números o guiones bajos.
- **Asignación de valores**: Usamos el signo `=` para asignar un valor a una variable.

```php
$nombre = "Juan";
$edad = 25;
$esEstudiante = true;
```

En este ejemplo:

- `$nombre` es una variable que almacena una cadena de texto (string).
- `$edad` es una variable que almacena un número entero (integer).
- `$esEstudiante` es una variable que almacena un valor booleano (boolean).

### Constantes en PHP

Las constantes son similares a las variables, pero su valor no puede cambiar una vez que se han definido. Se utilizan para almacenar valores que se deben mantener constantes a lo largo de la ejecución del script.

- **Definición**: Se definen usando la función `define()`.
- **Nombre de constantes**: Por convención, se escriben en mayúsculas.

```php
define("PI", 3.1416);
define("NOMBRE_DEL_SITIO", "Mi Sitio Web");
```

En este ejemplo:

- `PI` es una constante que almacena el valor de Pi.
- `NOMBRE_DEL_SITIO` es una constante que almacena una cadena de texto.

### Ejemplo Completo

Un pequeño script que usa variables, constantes y diferentes tipos de datos:

```php
<?php
// Definimos una constante
define("TASA_IMPUESTO", 0.18);

// Definimos variables
$producto = "Laptop";
$precio = 1200.50;
$cantidad = 2;
$totalSinImpuesto = $precio * $cantidad;
$totalConImpuesto = $totalSinImpuesto * (1 + TASA_IMPUESTO);

// Mostramos los valores
echo "Producto: $producto\n";
echo "Precio unitario: $$precio\n";
echo "Cantidad: $cantidad\n";
echo "Total sin impuesto: $$totalSinImpuesto\n";
echo "Total con impuesto (18%): $$totalConImpuesto\n";
```

En este ejemplo:

- `TASA_IMPUESTO` es una constante.
- `$producto`, `$precio`, `$cantidad`, `$totalSinImpuesto` y `$totalConImpuesto` son variables.
- Utilizamos varios tipos de datos: cadenas de texto (strings), flotantes (floats) e integres (integers).