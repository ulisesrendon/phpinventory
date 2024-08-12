<?php

/*
Estructuras de condicion en PHP
*/

/*
Las esctructuras de condicion en PHP permiten ejecutar instrucciones basadas en ciertas condiciones.

## Condicion simple

La condición más básica se crea con "if" y genera la siguiente estructura:

Si (Condición es verdadera){
    Haz esto;
}

Se pueden establecer todo tipo de condiciones basadas en los datos con los que estemos trabajando, por ejemplo al trabajar con números:

*/
// Comprobar edad
$age = 16;
if( $age < 18 ){
    echo 'Eres menor de edad';
}
/*
En este código ponemos como condición que una variable de tipo numerico sea menor a otro valor numerico, en caso de ser así mostramos un mensaje.
*/

/*
Ahora veamos un ejemplo con cadenas de texto
*/

// Comprobar página que se visita
$page = 'index';
if($page == 'index'){
    // ... mostrar contenido de la pagina de inicio
    echo 'Estas en la página de inicio';
}

/*
En este código ponemos como condición que una variable de tipo texto corresponda con la palabra 'index', de ser así se lleva a cabo la instruccion de imprimir el mensaje.

## Condiciones multiples

Tanto para el ejemplo de comprobar edad como el ejemplo de comprobar pagina podemos ampliar la funcionalidad del código añadiendo mas condiciones y mas instrucciones que nuestro programa deba realizar si estas se cumplen, para esto usaremos las estructuras if-else y if-else if.

Las condiciones if-else tienen la siguiente estructura:

Si (Condición es verdadera){
    Haz esto;
}en su lugar{
    Haz esto otro;
}

Esta estructura funciona muy bien para casos en los que tenemos dos opciones, una condición principal y una condición por defecto.

Ampliando el ejemplo de la comprobación de edad tendríamos el siguiente código:
*/
$age = 16;
if ($age < 18) {
    echo 'Eres menor de edad';
}else{
    echo 'Eres mayor de edad';
}

/*
Ahora veamos las condiciones if-else if, las cuales tienen la siguiente estructura:

Si (Condición es verdadera){
    Haz esto;
}en su lugar Si (OtraCondición es verdadera)
    Haz esto otro;
}

Este tipo de estructura funciona cuando tenemos muchas opciones y queremos definir una instrución para cada opcion posible.

Ampliando el código de comprobar página con esta estructura quedaría tal que:
*/
$page = 'tienda';
if ($page == 'index') {
    // ... mostrar contenido de la pagina de inicio
    echo 'Estas en la página de inicio';
}else if ($page == 'tienda') {
    // ... mostrar contenido de la tienda
    echo 'Estas en la tienda';
}

/*
Con este cambio ahora podemos reaccionar a diferentes valores de la variable $page, pero no solo funciona con dos opciones, podemos apilar todas las condiciones extra que necesitemos e incluso al final podemos añadir una instrucción por defecto para cuando ninguna de las condiciones que establecimos se haya cumplido.

Ampliando aún más el código de comprobación de página:
*/

$page = 'contacto';
if ($page == 'index') {
    // ... mostrar contenido de la pagina de inicio
    echo 'Estas en la página de inicio';
} else if ($page == 'blog') {
    // ... mostrar contenido del blog
    echo 'Estas en el blog';
} else if ($page == 'tienda') {
    // ... mostrar contenido de la tienda
    echo 'Estas en la tienda';
} else if ($page == 'contacto') {
    // ... mostrar contenido de la página de contacto
    echo 'Estas en la página de contacto';
} else{
    // ... mostrar página de error
    echo 'Error 404 - Página no encontrada';
}

/*
Ahora tenemos una lista de opcion a las cuales código puede reaccionar según el valor la variable $page.
*/

/*
¿Cuando deberiamos usar condiciones simples?, ¿cuando deberíamos usar multiples condiciones?, ¿Cuando deberíamos combinar condiciones?

Según las reglas de negocio que debamos implementar en el softare necesitaremos combinar entre condiciones simples y multiples condiciones,

A continuación veremos un ejemplo un poco mas complejo para ejemplificar:

Creemos el código para una tienda, en el cual se calcula el precio a pagar según la cantidad que se requiera de un producto.

*/

define('TAX_MULTIPLIER', 1.16); // Impuesto base
$unitPrice = 100; // Precio por unidad de producto: $100
$isTaxed = true; // El producto tiene impuestos?

$quantity = 3; // El cliente selecciona la cantidad de productos a comprar

if ($isTaxed) {
    $unitPrice *= TAX_MULTIPLIER; // Precio unitario con impuestos: $116
}

$amount = $quantity * $unitPrice;

echo "<div>Total a pagar: $$amount</div>";  // A pagar: $348

/*
Hasta aquí el código ya realiza las operaciones necesarias para sumar el impuesto del producto y multiplicar por la cantidad que el cliente quiere comprar.

Ahora supongamos que se desea implementar un sistema de promociones, en el que pueden haber al mismo tiempo varias promociones activas.

Las condiciones serían las siguientes:
-Si compras mas de 2 unidades te damos una de regalo
-Si ingresas un cupón te hacemos un descuento del 10% o el 20%

En el código las condiciones serían las siguientes:
*/

// Si compras mas de 2 unidades te damos una de regalo
if ($quantity >= 3) {
    $amount = $amount - $unitPrice;
}

// Si ingresas un cupón te hacemos un descuento del 10%
if ($customerCoupon == 'PROMO10') {
    $amount = $amount - ($amount * 0.1);
}

// Si ingresas un cupón te hacemos un descuento del 20%
if ($customerCoupon == 'PROMO20') {
    $amount = $amount - ($amount * 0.2);
}

/*
Añadiendo las condiciones el código quedaría de la siguiente forma:
*/

define('TAX_MULTIPLIER', 1.16); // Impuesto base
$unitPrice = 100; // Precio por unidad de producto: $100
$isTaxed = true; // El producto tiene impuestos?

if ($isTaxed) {
    $unitPrice *= TAX_MULTIPLIER; // Precio unitario con impuestos: $116
}

$quantity = 3; // El cliente selecciona la cantidad de productos a comprar
$customerCoupon = 'PROMO20'; // El cliente proporciona un cupón de descuento

echo "<div>$$unitPrice (precio) x $quantity (cantidad)</div>";

$amount = $quantity * $unitPrice; // a pagar: $348

// Si compras mas de 2 unidades te damos una de regalo
if ($quantity >= 3) {
    $amount = $amount - $unitPrice; // descontamos el costo de una unidad
    echo "<div>Te regalamos una unidad</div>";
}

// Si ingresas un cupón te hacemos un descuento del 10%
if ($customerCoupon == 'PROMO10') {
    $amount = $amount - ($amount * 0.1);
    echo "<div>Aplicando cupon PROMO10, te descontamos 10%</div>";
}

// Si ingresas un cupón te hacemos un descuento del 20%
if ($customerCoupon == 'PROMO20') {
    $amount = $amount - ($amount * 0.2);
    echo "<div>Aplicando cupon PROMO10, te descontamos 20%</div>";
}

echo "<div>Total a pagar: $$amount</div>";

/*
Si ejecutamos el programa veremos que se estan aplicando las promociones, que en este caso son tanto la promoción de descontar una unidad en la compra de mas de dos unidades y la promoción del el cupón del 20% de descuento.
Si cambiamos la cantidad de unidades o cambiamos el cupón o incluso lo quitamos podremos ver como el programa correctamente calcula el precio en base a estas condiciones simples que hemos definido.
¿Pero que pasaría si no queremos que se aplique mas de una promoción al mismo tiempo? Pues en este caso tendríamos que cambiar un poco el código para cambiar las condiciones simples if por condiciones 1f-else if.
*/

// Si compras mas de 2 unidades te damos una de regalo
if ($quantity >= 3) {
    $amount = $amount - $unitPrice; // descontamos el costo de una unidad
    echo "<div>Te regalamos una unidad</div>";
}
// Ó si ingresas el cupón te hacemos un descuento del 10%
else if ($customerCoupon == 'PROMO10') {
    $amount = $amount - ($amount * 0.1);
    echo "<div>Aplicando cupon PROMO10, te descontamos 10%</div>";
}
// Ó si ingresas un cupón te hacemos un descuento del 20%
else if ($customerCoupon == 'PROMO20') {
    $amount = $amount - ($amount * 0.2);
    echo "<div>Aplicando cupon PROMO10, te descontamos 20%</div>";
}

/*
Con este cambio el código quedaría de la siguiente forma:
*/

define('TAX_MULTIPLIER', 1.16); // Impuesto base
$unitPrice = 100; // Precio por unidad de producto: $100
$isTaxed = true; // El producto tiene impuestos?

if ($isTaxed) {
    $unitPrice *= TAX_MULTIPLIER; // Precio unitario con impuestos: $116
}

$quantity = 3; // El cliente selecciona la cantidad de productos a comprar
$customerCoupon = 'PROMO20'; // El cliente proporciona un cupón de descuento

echo "<div>$$unitPrice (precio) x $quantity (cantidad)</div>";

$amount = $quantity * $unitPrice; // a pagar: $348

// Si compras mas de 2 unidades te damos una de regalo
if ($quantity >= 3) {
    $amount = $amount - $unitPrice; // descontamos el costo de una unidad
    echo "<div>Te regalamos una unidad</div>";
}
// Ó si ingresas el cupón te hacemos un descuento del 10%
else if ($customerCoupon == 'PROMO10') {
    $amount = $amount - ($amount * 0.1);
    echo "<div>Aplicando cupon PROMO10, te descontamos 10%</div>";
}
// Ó si ingresas un cupón te hacemos un descuento del 20%
else if ($customerCoupon == 'PROMO20') {
    $amount = $amount - ($amount * 0.2);
    echo "<div>Aplicando cupon PROMO10, te descontamos 20%</div>";
} 
else {
    echo "<div>Si compras mas de 2 unidades te damos una de regalo</div>";
    echo "<div>Registrate para recibir cupones de descuento en tu bandeja de entrada</div>";
    echo "<div>*Promociones no acumulables</div>";
}

echo "<div>Total a pagar: $$amount</div>";

/*
Al cambiar a la estructura if-else if ahora el programa solo permite aplicar una unica condición a la vez, y como un extra completamos la estructura con un else, para mostrar un mensaje cuando ningúna de las promociones se aplica.

## Conclusión

Aplicando correctamente las estructuras copndicionales podemos crear programas que tomen desiciones en base a la información que se les proporciona. 
Agrupando estructuras podemos definir comportamientos y reglas de negocio cada vez mas complejas.
A pesar de que en este articulo solo vimos ejemplos con una o dos variables con lo visto ya se puede pasar a logicas mas complejas, en las que haga falta anidar estructuras o evaluar multiples condiciones al mismo tiempo.
*/

