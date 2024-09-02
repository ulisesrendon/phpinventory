<?php
/*
Las funciones son estructuras que permiten encapsular código para permitir reutilizar y organizar instrucciones.

Al combinar correctamente funciones y bucles podremos crear código mas compacto, legible y modular.

La modularidad en el software consiste en separar nuestro programa en multiples partes mas pequeñas, cada una independiente del resto y algunas piezas siendo intercambiables por otras y cuando estos modulos stan bien construidos pueden ser reutilizados para re-componer aún mas software.

Creando tus propias funciones puedes definir instrucciones que se podrán ejecutar solo cuando tu lo requieras, puedes definir desde funciones básicas que encapsulen solo un par de instrucciones básicas hasta funciones con grandes cantidades de código que invocarán incluso a muchas otras funciones con sus respetivas instrucciones internas.

<h2>Creando una función básica</h2>

Veamos como empezar a crear y usar nuestras propias funciones, Pongamos de ejemplo la operacion de sumar los impuestos a un valor monetario dado.

Para crear una funcion que calcule impuestos usaremos la palabra reservada <strong>function</strong> para indicarle a php que estamos por definir una funcion, luego escribiremos un  nombre que hayamos inventado (debe seguir las mismas reglas de nombres que las variables y las constantes), a continuación del nombre pondremos unos parentesis y luego entre llaves escribiremos las instrucciones propias del algoritmo.

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
Al llamar a la función dos veces, ejecutaremos las instrucciones que encapsula dos veces, si ejecutamos la función aún más veces será el mismo compartamiento, pero no tiene mucho sentido hacer esta operacion con el mismo valor una y otra vez, el poder de las funciones reside en poder ser reutilizadas y para hacer que esta instrucción sea reutilizable necesitamos poder injectarle un valor de entrada que sea diferente en cada ocasión.

<h2>Creando funciones con parametros</h2>

<p>Las funciones pueden aceptar multiples valores de entrada para poder trabajar y como resultado estas pueden retornar un valor de salida.</p>

<p>Los parametros de una función son los valores que esta puede recibir </p>
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