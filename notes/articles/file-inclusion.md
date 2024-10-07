# Inclusion de archivos en PHP

Cómo combinar multiples archivos de php en uno solo y como insertar contenido de otros archivos.

<p>Una buena forma de mantener nuestro código más legible y gestionable es separarlo en multiples archivos, y luego cargar esos archivos solo cuando se requiera.</p>

<p>A php podemos darle en cualquier momento la instrucción de cargar otros archivos con más código, y así podemos crear software complejo compuesto de piezas de software mas pequeñas.</p>

<p>Aunque existe el detalle de que la instrucción para cargar archivos viene en 4 estilos que habrá que aplicar según el caso:</p>

<ol type="1">
    <li>include</li>
    <li>require</li>
    <li>include_once</li>
    <li>require_once</li>
</ol>


## Include vs Require

<p>La principal diferencia entre las instrucciones <strong>include</strong> y <strong>require</strong> es que si PHP no encuentra el archivo solicitado la primera mostrara un mensaje de error y luego continuara con la ejecución del resto del código, mientras que la instrucción "require" detendrá la ejecución del resto del programa tras mostrar el mensaje de error.</p>


## Incluir una única vez

<p>Las instrucciones <strong>require_once</strong> e <strong>include_once</strong> le indican a PHP que debe cuidar de incluir los archivos una única vez en el script.</p>

<p>Validar que los archivos se inserten una sola vez es útil para evitar errores por sobre escribir variables o por intentar duplicar constantes, funciones y clases ya existentes.</p>

## Como se usan las instrucciones para incluir archivos

<p>La forma de usarlas es la siguiente, escribimos primero la instrucción y después escribimos la localización del archivo, por ejemplo:</p>

```php
include 'dir/file.php';
```

<p>Las cuatro instrucciones tienen exactamente la misma sintaxis, simplemente su comportamiento cambiara si el archivo a importar no existe o si se esta intentando llamar multiples veces al mismo archivo.</p>

## Rutas relativas y rutas absolutas

<p>Hay que tener en cuenta que hay dos formas para llegar a los archivos, la forma absoluta y la forma relativa.</p>

<blockquote>Una ruta absoluta es como indicar una dirección postal de algún lugar, indicando país, ciudad, localidad, calle y casa, mientras que una ruta relativa es como dar direcciones para llegar a un lugar desde la ubicación actual, tipo avanza derecho tres calles y luego muévete dos calles a la izquierda para llegar al super.</blockquote>

### Rutas absolutas
<p>La forma absoluta se usa cuando necesitamos acceder a un archivo que es independiente a nuestro programa, pero para poder llegar a dicho archivo es necesario conocer su ubicación dentro del sistema.</p>

<p>Una ruta relativa se vería de la siguiente forma en windows:</p>

```
'C:/web/www/project/file.php';
```

<p>Y en Linux tendría la siguiente forma:</p>

```
'/var/www/project/file.php';
```

<p>Aunque esta forma permite llamar archivos desde cualquier otro archivo independientemente de su ubicación en el sistema, existen contras de trabajar con archivos de esta manera.</p>

<p>Al ser dependiente del sistema, cambiar el proyecto a otro entorno (Desplegar en producción por ejemplo) conlleva trabajo extra, cómo tener que validar que el archivo este en la ruta requerida o tener que estar cambiando la definición de la ruta según se requiera.</p>

<p>También se pueden usar rutas web absolutas para cargar archivos, pero se desaconseja completamente su uso, ya que esto conlleva problemas de seguridad, incluso viene desactivado por defecto en PHP.</p>

### Rutas relativas

<p>Las rutas relativas permiten trabajar con archivos independientemente del sistema en el que estamos, lo que nos permite mover el proyecto completo a otro entorno y de forma fácil.</p>

<p>Una ruta relativa se vería de la siguiente forma en cualquier sistema:<p>

```
'dir/file.php';
```

### Navegar entre los directorios del proyecto

<p>Al definir rutas se puede usar el comodín "dos puntos" para indicar que se necesita ir fuera del directorio inicial y navegar hacia archivos en otros directorios.</p>

<p>Para ejemplificar esto pensemos en un esquema de archivos como el siguiente:</p>

```
project/
    user/
        helper/
            PasswordEncrypt.php
        data/
            User.php
```
<p>Teniendo un proyecto con varios archivos, tenemos el archivo "User.php" en el que necesitamos código del archivo PasswordEncrypt.php.</p> 

<p>Aunque ambos archivos están en el mismo directorio en el mismo sistema, cada uno esta en un directorio diferente y estos están a la misma altura.</p>

<p>Para poder acceder a PasswordEncrypt desde User tendríamos que usar algo como:</p>

```php
# project/user/data/User.php
require '../helper/PasswordEncrypt.php'; // project/user/helper/PasswordEncrypt.php
```

<p>Con esto le indicaríamos a PHP la ruta correcta para que encuentre el archivo y lo inserte en el programa.</p>

<p>Pero esta forma también tiene sus inconvenientes, ¿qué pasaría si ahora desde un tercer archivo en otro directorio diferente intentamos llamar al archivo User.php?</p>

<p>Esto podría derivar en problemas ya que al ser una ruta relativa, depende del archivo PHP en ejecución.</p>

<p>A continuación veremos la forma definitiva para crear programas que se componen de multiples archivos.</p>

## La forma ideal de trabajar con inclusión de archivos en php

<p>Pensando el el esquema de archivos del ejemplo anterior pero ahora teniendo en cuenta un tercer archivo (public/index.php) que será el que se encargue de llamar a User.php para ejecutarlo tendríamos:</p>
```
project/
    user/
        helper/
            PasswordEncrypt.php
        data/
            User.php
    public/
        index.php
```
<p>Si dejamos el código como lo teníamos antes fallará por el tema de la ruta relativa.</p>

```php
# project/public/index.php
require '../user/data/User.php'; 
```


## Usando la sentencia return en archivos a insertar


## En resumen