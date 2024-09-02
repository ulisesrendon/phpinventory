<?php
/*
Las funciones son estructuras que permiten encapsular código para permitir reutilizar y organizar instrucciones.

Al combinar correctamente funciones y bucles podremos crear código mas compacto, legible y modular.

La modularidad en el software consiste en separar nuestro programa en multiples partes mas pequeñas, cada una independiente del resto y algunas piezas siendo intercambiables por otras y cuando estos modulos stan bien construidos pueden ser reutilizados para re-componer aún mas software.

Creando tus propias funciones puedes definir instrucciones que se podrán ejecutar solo cuando tu lo requieras, puedes definir desde funciones básicas que encapsulen solo un par de instrucciones básicas hasta funciones con grandes cantidades de código que invocarán incluso a muchas otras funciones con sus respetivas instrucciones internas.

<h2>Creando una función básica</h2>

Veamos como empezar a crear y usar nuestras propias funciones, Pongamos de ejemplo la operacion de sumar los impuestos a un valor monetario dado.

Para crear una funcion que calcule impuestos usaremos la palabra reservada <strong>function</strong> para indicarle a php que estamos por definir una funcion, luego escribiremos un  nombre que hayamos inventado (debe seguir las mismas reglas de nombres que las variables y las constantes), a continuación del nombre pondremos unos parentesis y luego entre llaves escribiremos las instrucciones propias del algoritmo.

Debemos de tener mucho cuidado al nombrar nuestras funciones ya que si llegaran a colisionar con el nombre de alguna función existente (ya sea alguna función definida por nosotros o definida por modulos que empleemos o por una función propia de PHP) el código simplemente fallara en cuanto PHP detecte que se intenta duplicar el nombre de una función.

El código para la función quedara de la siguiente forma:
*/

function taxPrice()
{
    $value = 238; // Valor inicial
    $taxedValue = $value * (1 + 0.16); // Aplicamos el impuesto 

    echo "Valor sin impuesto: \${$value}<br>";
    echo "Valor con impuesto (16%): \${$taxedValue}<br>";
}

/*
Una vez definida ya podemos invocar a nuestra funcion las veces que sea necesario, y para ello solo debemos escribir el nombre de la funcion seguida de parentesis y terminando con punto y coma como cualquier otra instrucción, invoquemosla por ejemplo dos veces solo para ver su comportamiento:

*/

taxPrice();
taxPrice();

/*
Valor sin impuesto: $238<br>
Valor con impuesto (16%): $276.08<br>

Valor sin impuesto: $238<br>
Valor con impuesto (16%): $276.08<br>
*/

/*
Al llamar a la función dos veces, ejecutaremos las instrucciones que encapsula dos veces, si ejecutamos la función aún más veces será el mismo compartamiento, pero no tiene mucho sentido hacer esta operacion con el mismo valor una y otra vez, el poder de las funciones reside en poder ser reutilizadas y para hacer que esta instrucción sea reutilizable necesitamos poder injectarle un valor de entrada que sea diferente en cada ocasión.
*/

/*

<h2>Creando funciones con parametros y argumentos</h2>

<p>Las funciones pueden aceptar multiples valores de entrada para poder trabajar y como resultado estas pueden retornar un valor de salida.</p>

<p>Los argumentos de una función son los valores que esta puede recibir, para nuestro ejemplo solo se necesita un unico valor, cambiaremos la función par aceptar como argumento el valor de la variable $value (que previamente definimos con el valor 238).

Para definir el argumento de una funcion debemos usar la misma sintaxis que para una variable y asignar un nombre de variable que contendra el valor y lo pasaremos a la función  usando los parentesis de esta, la función quedara de la siguiente manera:</p>
*/

function taxPrice($value)
{
    $taxedValue = $value * (1 + 0.16); // Aplicamos el impuesto 

    echo "Valor sin impuesto: \${$value}<br>";
    echo "Valor con impuesto (16%): \${$taxedValue}<br>";
}

/*
Ahora podemos llavar nuestra función pasandole diferentes valores y ahora si estaremos reutilizando nuestro código, par esto al invocar la función debemos pasar el valor neceasrio entre los parentesis de la función tal que así:
*/

taxPrice(100);
taxPrice(458);
taxPrice(299);

/*
Valor sin impuesto: $100<br>
Valor con impuesto (16%): $116<br>

Valor sin impuesto: $458<br>
Valor con impuesto (16%): $531.28<br>

Valor sin impuesto: $299<br>
Valor con impuesto (16%): $346.84<br>
*/

/*
Los terminos argumento y parametro se suelen usar indistintamente aunque tecnicamente son dos cosas diferentes aunque relacionadas, el argumento hace referencia al valor que se le pasa a la función y con el que esta opera, mientras que el termino parametro hace referencia a las variables que contienen esos valores.
*/

/*

<h2>Funciones propias de PHP</h2>

PHP cuenta con sus propias funciones internas para ayudarnos a resolver todo tipo de problemas, en este sitio web veremos muchas de ellas, pero aún así te recomiendo buscar y aprender a usar las que sean de tu interes.

Por nombrar algunos de los apartados de funciones que tiene PHP:
<ul>
    <li>Gestion de archivos</li>
    <li>Procesamiento de texto</li>
    <li>Conexión con bases de datos</li>
    <li>Envio de correo electronico</li>
    <li>Envio de peticiones http a otros servidores</li>
    <li>Implementación de seguridad mediante criptografia</li>
    <li>Operaciones con fechas</li>
    <li>Generación y procesado de imagenes</li>
    <li>Operaciones matematicas</li>
</ul>
*/

/*
Si en el ejmplo anterior quisieramos cambiar los textos o mostrar mas información o si se desea cambiar la operación tendremos problemas, ya que al cambiar la función se cambiara el resultado en todos los lugares del software donde esta se este invocando, 

Para ganar mayor flexibilidad siempre es recomendable separar nuestro código en trozos lo mas pequeños posibles, y evitar repetir código siempre que sea posible.

<h2>Funciones que retornan valores</h2>

Como ya mencionamos, ademas de recibir argumentos de entrada para operar, las funciones pueden retornar valores para luego usar estos valores en otras partes del código o incluso en otras funciones.
*/

define("TAX_FEE", 0.16);
$product = "Laptop";
$price = 12090.99;
$quantity = 2;

$total = $price * $quantity;

echo "Producto: {$product}\n";
echo "Precio unitario: \${$price}\n";
echo "Cantidad: {$quantity}\n";
echo "Total sin impuesto: \${$total}\n";

$total = $total * (1 + TAX_FEE);
echo "Total con impuesto (16%): \${$total}\n";