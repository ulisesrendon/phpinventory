<?php

/*
<p>La sintaxis de este bucle es muy simple, solo se escribe foreach y entre paréntesis indicamos cual es el arreglo a iterar seguido de la palabra "as",  luego una variable que servirá de alías para acceder al elemento que el bucle esta accediendo en ese momento y finalmente entre llaves indicaremos las instrucciones a repetir en cada ciclo del bucle.</p>

<p>El bucle foreach nos permite también acceder a las llaves del arreglo, conociendo la llave podemos usarla para añadir mas información útil añadiendo una dimensión extra de datos, ademas de que es necesario poder acceder a la llave para poder modificar los elementos dentro del arreglo.</p>
<p>para acceder a la llave hay que indicarla en el bucle con una variable alias seguida del operador "=>" (flecha doble) quedando de la siguiente forma:</p>

<pre><code>foreach($arreglo as $clave => $valor){
    // Instrucciones a repetir en cada ciclo ...
}</code></pre>

<p>Veamos un ejemplo para dejarlo claro</p>
*/

$days = [
    1 => 'domingo',
    2 => 'lunes',
    3 => 'martes',
    4 => 'miércoles',
    5 => 'jueves',
    6 => 'viernes',
    7 => 'sábado',
];

foreach($days as $dayNumber => $dayName){
    echo "{$dayNumber} - {$dayName}<br>";
}

/*
<div class="code-sample" data-url="bucles-ejemplo-2.php">
1 - domingo<br>
2 - lunes<br>
3 - martes<br>
4 - miércoles<br>
5 - jueves<br>
6 - viernes<br>
7 - sábado<br>
</div>

<p>Este es un arreglo típico en el que tenemos una lista de opciones numerada, donde el número de la opción si que es importante y es un dato que nos interesa conocer.</p>

<p>Ahora veamos como recorrer una tabla de datos anidando bucles foreach, para este ejemplo usaremos una tabla de datos de usuarios y vamos a imprimirla en forma de una tabla HTML.</p>

*/

$users = [
    [
        'id' => 3200, 
        'name' => 'Juan Perez', 
        'email' => 'juan@app.test', 
        'status' => 1,
    ],
    [
        'id' => 3201, 
        'name' => 'Cris Rodriguez', 
        'email' => 'cris@app.test', 
        'status' => 0,
    ],
    [
        'id' => 3202, 
        'name' => 'Luis Hernández', 
        'email' => 'Luis@app.test', 
        'status' => 1,
    ],
    [
        'id' => 3203, 
        'name' => 'Juana Alvarez', 
        'email' => 'juana@app.test', 
        'status' => 1,
    ],
];

echo "<table>";
foreach($users as $user){
    echo "<tr>";
    foreach($user as $property => $value){
        echo "<td><strong>{$property}</strong>: {$value}</td>";
    }
    echo "</tr>";
}
echo "</table>";

/*
<div class="code-sample" data-url="bucles-ejemplo-2.php">
    <table>
        <tr>
            <td><strong>id</strong>: 3200</td>
            <td><strong>name</strong>: Juan Perez</td>
            <td><strong>email</strong>: juan@app.test</td>
            <td><strong>status</strong>: 1</td>
        </tr>
        <tr>
            <td><strong>id</strong>: 3201</td>
            <td><strong>name</strong>: Cris Rodriguez</td>
            <td><strong>email</strong>: cris@app.test</td>
            <td><strong>status</strong>: 0</td>
        </tr>
        <tr>
            <td><strong>id</strong>: 3202</td>
            <td><strong>name</strong>: Luis Hernández</td>
            <td><strong>email</strong>: Luis@app.test</td>
            <td><strong>status</strong>: 1</td>
        </tr>
        <tr>
            <td><strong>id</strong>: 3203</td>
            <td><strong>name</strong>: Juana Alvarez</td>
            <td><strong>email</strong>: juana@app.test</td>
            <td><strong>status</strong>: 1</td>
        </tr>
    </table>
</div>

<h2>Bucle For</h2>

<p>Este bucle repetirá las instrucciones indicadas hasta que se deje cumplir una condición dada.</p>
<p>El bucle For se utiliza cuando se quieren repetir las instrucciones deseadas una cantidad especifica de veces.</p>
<p>Para usar el bucle for es necesario saber que este se compone de varias partes, primero en su definición tenemos 3 secciones:</p>
<ol type="1">
    <li>Inicialización: Se definen una o multiples variables antes de empezar con el bucle, normalmente aquí se define un valor para llevar la cuenta de cuantas veces se ha ejecutado el bucle</li>
    <li>Evaluación: Se evalúa una condición en cada ciclo para determinar si el bucle debe continuar una vez más o detenerse</li>
    <li>Cambio con cada ciclo: Se cambia algún valor en cada ciclo, lo normal suele ser cambiar el valor de la variable que lleva la variable definida en un inicio que lleva la cuenta.</li>
</ol>
<p>Suena mas complicado de lo que realmente es, veamos como quedaría finalmente el bucle for:</p>

<pre><code>for($i=1; $i<=10; $i++){
    echo "{$i}<br>";
}</code></pre>

<p>Si corremos este trozo de código el bucle imprimirá los números del 1 al 10</p>

<p>la variable $i sirve para definir un valor inicial que llevara la cuenta, luego tenemos la condición que mientras $i sea menor o igual a diez el bucle debe repetir la instrucción definida y en cada ciclo debe aumentar en uno el valor de $i y finalmente la instrucción a repetir es la de imprimir el valor que lleva la cuenta.</p>

<p>Veamos otro ejemplo, en un sitio donde se tiene cierta cantidad de elementos y se desea paginar esos elementos, sabiendo la cantidad de paginas existentes (13 por ejemplo), usando el bucle for podemos generar la paginación de forma simple:</p>

<pre><code>for($i=1; $i<=13; $i++){
    echo "<a href=\"http://localhost/app?page={$i}\">{$i}</a> ";
}</code></pre>

<div class="code-sample" data-url="bucles-ejemplo-3.php">
    <a href="http://localhost/app?page=1">1</a> 
    <a href="http://localhost/app?page=2">2</a> 
    <a href="http://localhost/app?page=3">3</a> 
    <a href="http://localhost/app?page=4">4</a> 
    <a href="http://localhost/app?page=5">5</a> 
    <a href="http://localhost/app?page=6">6</a> 
    <a href="http://localhost/app?page=7">7</a> 
    <a href="http://localhost/app?page=8">8</a> 
    <a href="http://localhost/app?page=9">9</a> 
    <a href="http://localhost/app?page=10">10</a> 
    <a href="http://localhost/app?page=11">11</a> 
    <a href="http://localhost/app?page=12">12</a> 
    <a href="http://localhost/app?page=13">13</a>
</div>

<p>El bucle for se puede usar también para recorrer arreglos simples, de hecho en otros lenguajes de programación el bucle for es el modo estándar para iterar sobre arreglos.</p>

<p>¿Pero en PHP que sentido tendría usar el bucle for sobre el mas simple y cómodo bucle foreach?</p>

<p>Pues con el bucle for podemos iterar arreglos sin tener que empezar por el inicio, podemos por ejemplo recorrerlos en reversa.</p>

<p>Veamos el ejemplo anterior de imprimir un arreglo con los días de la semana pero ahora en reversa:</p>

<pre><code>$days = [
    1 => 'domingo',
    2 => 'lunes',
    3 => 'martes',
    4 => 'miércoles',
    5 => 'jueves',
    6 => 'viernes',
    7 => 'sábado',
];

for($i = 7; $i>0; $i--){
    echo "{$i} - {$days[$i]}<br>";
}</code></pre>

<div class="code-sample" data-url="bucles-ejemplo-4.php">
7 - sábado<br>
6 - viernes<br>
5 - jueves<br>
4 - miércoles<br>
3 - martes<br>
2 - lunes<br>
1 - domingo<br>
</div>

<p>Hay que poner mucha atención a la condición del bucle y al valor que se cambia en cada ciclo, si el valor no se cambiase correctamente el ciclo no terminaría y se ejecutaría infinitamente (ó hasta que el motor de php alcance el límite de memoria asignado.) y si la condición es incorrecta el bucle podría no ejecutarse o podría ejecutarse menos o más veces de las esperadas.</p>

<h2>El bucle while</h2>

<p>Esta estructura repetitiva permite ejecutar multiples veces las instrucciones que agrupa en su interior mientras se cumpla una condición dada, la cual se evalúa en cada repetición</p>

<p>Este bucle tiene la siguiente sintaxis:</p>

<pre><code>while($condicion){
// Instrucciones ...
}</code></pre>

<p>El bucle while es más sencillo pero más flexible que los bucles anteriores, al igual que los bucles anteriores puede usarse para recorrer arreglos, aunque lo mas fácil sería recorrerlos con foreach o con for, pero veamos como sería para entender la sintaxis de este bucle</p>
*/
$colors = ['red', 'green', 'blue'];
$i = 0;
while($i < 3){
    echo "{$colors[$i]}<br>";
    $i++;
}

/*
<p>Al igual que con el bucle for, para recorrer arreglos tendríamos que definir una variable que lleve la cuenta, luego debemos definir la condición que se evaluara para saber si el ciclo debe continuar o no y por último debemos incrementar el valor de la variable que lleva la cuenta, pero de estas tres cosas ninguna forma parte del bucle propiamente</p>

<p>Para que veas a a que me refiero veamos un bucle while sin una condición que evaluar:</p>
*/
$colors = ['red', 'green', 'blue'];
$i = 0;
while (true) {
    echo "{$colors[$i]}<br>";
    $i++;
    if($i >= 3){
        break;
    }
}

/*
<p>El bucle while se puede simplemente establecer con el valor booleano true para que se ejecute indefinidamente y dentro del bucle</p>
*/

$startingHour = 8;
$endingHour = 10;
$duration = 40;

$slotHour = $startingHour;
$slotMinute = 0;

$slots = [];

while (true) {
    $slots[] = [$slotHour, $slotMinute];

    $slotMinute += $duration;
    if ($slotMinute >= 60) {
        $slotMinute -= 60;
        $slotHour++;
    }

    if ($slotHour >= $endingHour) {
        break;
    }
}



$startingHour = 8;
$endingHour = 10;
$duration = 50;

$slotHour = $startingHour;
$slotMinute = 0;

$slots = [];

while ($slotHour < $endingHour) {
    $slots[] = [$slotHour, $slotMinute];
    $slotMinute += $duration;
    if ($slotMinute >= 60) {
        $slotMinute -= 60;
        $slotHour++;
    }
}