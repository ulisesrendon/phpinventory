# Arreglos en PHP

Los arreglos son una herramienta del lenguaje que permite agrupar datos en forma de lista y dentro de una sola variable, esto con el fin de organizar datos y permitir una manupulación más fácil y eficiente, permitiendo de forma clara ordenar, buscar y filtrar elementos.

En un arreglo se pueden ingresar datos de cualquier tipo, incluso otros arreglos, lo que permite crear estructuras mas complejas.

Empezar a crear arreglos es muy fácil, solo debemos definir una variable y asignarle como valor un par de corchetes, uno de apertura y uno decierre, lo que le indica al lenguaje que queremos definir un arreglo vacio.

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
¿Y como recuperamos datos de un arreglo?, en un arreglo la información se almacena en forma de una lista númerada pero empezando por el numero cero, por lo que la forma de acceder a nuestra información sería la siguiente:

```php
echo $colors[0]; // rojo
echo $colors[1]; // verde
echo $colors[2]; // azul
```
La forma de acceder a un elemento dentro de un arreglo es mediante el nombre de la variable seguido de el número de su posición, la posicion se ingresa entre corchetes y de esta forma podemos acceder al dato deseado.

¿Como se cambia el valor de un elemento dentro de un arreglo?

Tal como accedemos a un arreglo podemos modificarlo, solo necesitamos escribir el nombre de la variable que contiene el arreglo e indicar entre corchetes la clave del elemento que necesitamos modificar, ejemplo:

```php
$colors[0] = 'morado';
echo $colors[0]; // morado
```
A la posicion de un elemento dentro de un arreglo se le conoce como llave ó clave por su nombre en ingles "Key" y no solo puede contener números, puede contener cualquier caracter alfanumerico.

Aún trabajando solo con claves númericas no es obligatorio comenzar desde el cero, manualmente se pueden definir las claves y asingarles el valor que se desee, pudiendo empezar desde cualquier número, ejemplo:

```php
$colors = [];
$colors[1] = 'rojo';
$colors[2] = 'verde';
$colors[3] = 'azul';

echo $colors[1]; // rojo
echo $colors[2]; // verde
echo $colors[3]; // azul
```
En este ejemplo definimos un arreglo vacio y a continuación asignamos los valores ingresando la clave que mas conveniente nos parezca, ahora veamos un ejemplo asignando claves alfanumericas:

```php
$days = [];
$days['dom'] = 'domingo';
$days['lun'] = 'lunes';
$days['mar'] = 'martes';
$days['mie'] = 'miercoles';
$days['jue'] = 'jueves';
$days['vie'] = 'viernes';
$days['sab'] = 'sabado';

echo $days['jue']; // jueves
echo $days['sab']; // sabado
```

En este ejemplo vemos una forma de organizar los nombres de los días en un solo arreglo y acceder a ellos mediante su forma abreviada.


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