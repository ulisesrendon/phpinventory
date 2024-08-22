# Arreglos en PHP

Los arreglos son una herramienta del lenguaje que permite agrupar datos en una sola variable en forma de lista, esto con el fin de organizar, ordenar, buscar y filtrar elementos, permitiendo una manupulación de datos más fácil y eficiente.

En un arreglo se pueden ingresar datos de cualquier tipo, incluso otros arreglos, lo que permite crear estructuras mas complejas.

## Arreglos simples

Empezar a crear arreglos es muy fácil, solo debemos definir una variable y asignarle como valor un par de corchetes, uno de apertura y uno de cierre, lo cual le indica al lenguaje que queremos generar un arreglo vacio.

```php
$data = [];
```
Para añadir datos a nuestro arreglo se usa el formato $data[] = 'data';, para ejemplificarlo añadamos los nombres de los colores a un arreglo llamado $colors:

```php
$colors = [];
$colors[] = 'rojo';
$colors[] = 'verde';
$colors[] = 'azul';
```
¿Y como recuperamos datos de un arreglo?, en un arreglo la información se almacena en forma de lista, pero por defecto la lista es númerada y empieza a contar por el numero cero, por lo que la forma de acceder a nuestra información sería la siguiente:

```php
echo $colors[0]; // rojo
echo $colors[1]; // verde
echo $colors[2]; // azul
```
La forma de acceder a los datos de un arreglo es mediante el nombre de la variable seguido de la posición del elemento, la posicion se indica entre corchetes.

¿Como se cambia el valor de un elemento dentro de un arreglo?

Tal como accedemos a un arreglo podemos modificarlo, solo necesitamos escribir el nombre de la variable que contiene el arreglo e indicar la posicion del elemento que necesitamos modificar, ejemplo:

```php
$colors[0] = 'morado';
echo $colors[0]; // morado
```
A la posicion de un elemento dentro de un arreglo se le conoce como llave ó clave por su nombre en ingles "Key" y no solo puede contener números, puede contener cualquier caracter alfanumerico.

Aún trabajando solo con claves númericas no es obligatorio comenzar desde el cero, ni siquiera es necesario asignar números consecutivos e incluso se pueden ingresar valores negativos.

Veamos un ejemplo de asignación manual de claves:

```php
$colors = [];
$colors[1] = 'rojo';
$colors[2] = 'verde';
$colors[4] = 'azul';

echo $colors[1]; // rojo
echo $colors[2]; // verde
echo $colors[4]; // azul
```
En este ejemplo definimos un arreglo vacio y a continuación asignamos los valores ingresando las claves deseadas.

Támbien podemos definir una variable como arreglo y al mismo tiempo asignarle los valores, todo en la misma estructura, para ello entre los corchetes caracteristicos de un arreglo se agregan los valores a asignar, separados por coma, por ejemplo:

```php
$fruits = ['peras', 'manzanas', 'uvas'];  // Caja de frutas

echo $fruits[0]; // peras
echo $fruits[1]; // manzanas
```
Gracias a esta forma abreviada y directa de definir arreglos es que se suele decir que los arreglos son como cajas que contienen cosas, donde los corchetes son las paredes que delimitan esas cajas.

## Areglos asociativos

Cuando usamos claves alfanumericas ó usamos números pero de forma no consecutiva ó usamos números de forma consecutiva pero sin empezar por el número cero la esctructura recibe el nombre de arreglo asociativo.

Veamos un ejemplo de arreglo asociativo con claves alfanumericas:

```php
$days = [];
$days['dom'] = 'domingo';
$days['lun'] = 'lunes';
$days['mar'] = 'martes';
$days['mie'] = 'miercoles';
$days['jue'] = 'jueves';
$days['vie'] = 'viernes';
$days['sab'] = 'sabado';

echo $days['lun']; // lunes
echo $days['dom']; // domingo
```
En este ejemplo vemos una forma de organizar los nombres de los días en una sola variable y acceder a ellos mediante los nombres abreviados de los días.

Ahora veamos ese mismo ejemplo pero en la forma abreviada de definir arreglos.

```php
$days = [
    'dom' => 'domingo',
    'lun' => 'lunes',
    'mar' => 'martes',
    'mie' => 'miércoles',
    'jue' => 'jueves',
    'vie' => 'viernes',
    'sab' => 'sábado',
];

echo $days['lun']; // lunes
echo $days['dom']; // domingo
```
Aquí cambia un poco el formato, ya que ahora debemos introducir el operador "=>" (flecha doble) ya que al definir un arreglo de forma directa con claves personalizadas es necesario indicar cual es la clave y cual es el valor del elemento.

Lo que esta a la izquierda del operador "flecha doble" siempre representa la clave del elemento dentro del arreglo y del lado derecho siempre se indica el valor, y aquí se hace evidente que los arreglos en php son una coleción de claves y valores.

A este tipo de estructuras tipo clave => valor también se les conoce como diccionarios ya que de un lado tenemos una palabra y del otro lado tenemos la defición (palabra => definición) aunque también se les conoce como mapas ya que sabiendo la dirección (la clave) se puede llegar a un lugar deseado (el valor) (dirección => lugar).

Hasta aquí hemos visto que un arreglo asociativo (claves alfanumericas) se define y se comporta muy parecido a un arreglo simple (claves númericas consecutivas empezando por el cero) y ambos permiten agrupar datos en forma de lista, ahora toca ver como se pueden combinar para crear estructuras mas complejas.

## Arreglos multidimencionales

Podemos asignar arreglos como valores dentro de otros arreglos, de esta forma se pueden asignar aún mas datos a una unica variable, pero de esta forma los datos son menos una lista y mas como una tabla, la cual contine celdas con muchos datos que a su vez pueden contener a otras tablas.

Empecemos con un ejemplo simple, imagina que queremos hacer una pequeña app para ayudarnos a hacer las compras, empecemos creando una estructura para gestionar nuestra lista de compras:

```php
$products = [
    [
        'name' => 'leche', 'found' => false,
    ],
    [
        'name' => 'manzanas', 'found' => false,
    ],
];
```
Tenemos un arreglo de productos que contiene un arreglo con el nombre del producto y un dato que nos sirva como check de que si encontramos el producto al ir a la tienda.

Si queremos imprimir el nombre del primer producto de la lista por comprar tendríamos que hacer lo siguiente:
```php
echo $products[0]['name']; // leche
```
Y al haber comprado el item ahora tendríamos que cambiar el valor de found por un true:
```php
$products[0]['found'] = true;
```
Y si por el camino se nos ocurre añadir un producto mas a la lista el código a usar sería el siguiente:

```php
$products[] = ['name' => 'azúcar', 'found' => false];
```
¿Y si por el camino preferimos olvidarnos de las manzanas y en su lugar compramos peras? pues ahora tendríamos que usar el siguiente código (recordando que las manzanas estan en la posicion 1):

```php
$products[1] = ['name' => 'peras', 'found' => true];
```
Pues ya hemos hecho nuestra lista de compras con un check para saber si logramos comprar los items o no, ahora vamos a imprimir nuestra tabla:
```php
echo "Nombre: {$products[0]['name']} - Encontrado: {$products[0]['found']}";
echo "Nombre: {$products[1]['name']} - Encontrado: {$products[1]['found']}";
echo "Nombre: {$products[2]['name']} - Encontrado: {$products[2]['found']}";
```



```php
$months = [];
$months['ene'] = 'enero';
$months['feb'] = 'febrero';
$months['mar'] = 'marzo';
$months['abr'] = 'abril';
$months['may'] = 'mayo';
$months['jun'] = 'junio';
$months['jul'] = 'julio';
$months['ago'] = 'agosto';
$months['sep'] = 'septiembre';
$months['oct'] = 'octubre';
$months['nov'] = 'noviembre';
$months['dic'] = 'diciembre';
```