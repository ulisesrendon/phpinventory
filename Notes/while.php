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


<p>Para saltar instrucciones dentro de un bucle, o para el caso del bucle foreach, saltar elementos de un arreglo tenemos la instrucción <mark>continue;</mark>, la cual le dice a PHP que salte al siguiente ciclo del bucle sin importar que otras instrucciones estuvieran después.</p>

<p>Para ejemplificarlo vamos a recorrer el mismo arreglo de hace un momento, pero vamos a hacer que salte a los usuarios con los id 3201 y 3202:</p>

*/

echo "<table>";
foreach($users as $user){
    if($user['id'] == 3201 || $user['id'] == 3202){
        continue;
    }
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
            <td><strong>id</strong>: 3203</td>
            <td><strong>name</strong>: Juana Alvarez</td>
            <td><strong>email</strong>: juana@app.test</td>
            <td><strong>status</strong>: 1</td>
        </tr>
    </table>
</div>

<p>Para poder detener por completo un bucle usamos la instrucción <mark>break;</mark>, para ver su funcionamiento hagamos que el bucle solo imprima hasta el usuario del id 3201:</p>

*/

echo "<table>";
foreach($users as $user){
    echo "<tr>";
    foreach($user as $property => $value){
        echo "<td><strong>{$property}</strong>: {$value}</td>";
    }
    echo "</tr>";
    if ($user['id'] == 3201) {
        break;
    }
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
<p>El bucle while puede simplemente usarse pasándole el valor booleano true para que se ejecute indefinidamente, pero para que no de lugar a un bucle infinito dentro de las instrucciones del bucle podemos evaluar cuando debería detenerse y usar la instrucción <mark>break</mark> para finalizar el bucle.</p>

<p>Para ejemplificar un bucle que se ejecuta indefinidamente veamos un algoritmo muy común</p>

<p>Este algoritmo se usa para generar una lista de horarios de disponibilidad (pueden ser horarios de atención en un consultorio, horarios estimados de salida y llegada para una ruta de algún transporte, espacios de alquiler de un aula o un local, etc.)</p>
*/

/*
<p>El código sería el siguiente y en seguida lo desgranaremos:</p>
*/
$startingHour = 8;
$endingHour = 10;
$duration = 40;

$slots = [];

$slotHour = $startingHour;
$slotMinute = 0;

while (true) {
    $slots[] = [
        'hour' => $slotHour, 
        'minute' => $slotMinute
    ];

    $slotMinute += $duration;
    if ($slotMinute >= 60) {
        $slotMinute -= 60;
        $slotHour++;
    }

    if ($slotHour >= $endingHour) {
        break;
    }
}

echo "<h3>Horarios disponibles</h3>";
echo "<ul>";
foreach ($slots as $time) {
    if (0 == $time['minute']) {
        $time['minute'] = '00';
    }
    echo "<li>{$time['hour']}:{$time['minute']}</li>";
}
echo "</ul>";

/*
<div class="code-sample" data-url="bucles-ejemplo-5.php">>
    <h3>Horarios disponibles</h3>
    <ul>
        <li>8:00</li>
        <li>8:40</li>
        <li>9:20</li>
        <li>10:00</li>
        <li>10:40</li>
        <li>11:20</li>
        <li>12:00</li>
        <li>12:40</li>
        <li>13:20</li>
    </ul>
</div>
*/

/*
<p>Lo primero es empezar definiendo 3 valores iniciales necesarios para el funcionamiento, la hora de inicio, la hora de finalización y la duración (en minutos) o tiempo separación entre disponibilidades.</p>

<p>Después tenemos el arreglo que almacenara la lista de horarios disponibles seguido de dos valores que llevan la cuenta de la hora y minuto que irán cambiando con cada ciclo.</p>

<p>Luego tenemos nuestro bucle while que se ejecutara indefinidamente</p>

<p>Dentro del bucle tenemos la instrucción de guardar el horario en cada iteración, el cual ira cambiando en intervalos definidos por la duración establecida.</p>

<p>En seguida tenemos el calculo del tiempo, en el que se suma la variable con la duración a la variable que lleva la cuenta de los minutos y por cada 60 minutos que se completen, se debe volver a empezar en cero los minutos y se debe incrementar en uno la variable que lleva la cuenta de las horas.</p>

<p>Por ultimo dentro del bucle tenemos la condición que detendrá la ejecución del bucle para evitar que siga calculando horarios infinitamente.</p>

<p>En cuanto el valor que lleva la cuenta de las horas alcance al valor de la hora de finalización detenemos el ciclo.</p>

<p>Ahora simplemente imprimimos en HTML una lista con los horarios que generamos usando un bucle foreach.</p>
*/


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


/*--------------------------------*/

$startingHour = 22;
$endingHour = 8;
$duration = 60;

$dayCicles = 1;

$slots = [];

$slotHour = $startingHour;
$slotMinute = 0;

while (true) {
    $slots[] = [
        'hour' => $slotHour,
        'minute' => $slotMinute
    ];

    $slotMinute += $duration;
    if ($slotMinute >= 60) {
        do {
            $slotMinute -= 60;
            $slotHour++;
        } while ($slotMinute >= 60);
    }

    if ($slotHour >= 24) {
        do {
            $slotHour -= 24;
            $dayCicles--;
        } while ($slotHour >= 24);
    }

    if ($slotHour >= $endingHour && $dayCicles == 0) {
        break;
    }
}

echo "<h3>Horarios disponibles</h3>";
echo "<ul>";
foreach ($slots as $time) {
    if (0 == $time['minute']) {
        $time['minute'] = '00';
    }
    $time['hour'] = str_pad($time['hour'], 2, "0", STR_PAD_LEFT);
    $time['minute'] = str_pad($time['minute'], 2, "0", STR_PAD_LEFT);

    echo "<li>{$time['hour']}:{$time['minute']}</li>";
}
echo "</ul>";