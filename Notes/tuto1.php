<?php

namespace Lib\Database;

use PDO;

class DataBaseAccess implements DatabaseFetchQuery
{
    public function __construct(private readonly PDO $PDO)
    {
    }

    public function fetchQuery(string $query, array $params = []): ?array
    {
        $PDOStatement = $this->PDO->prepare($query);
        $result = $PDOStatement->execute($params);
        if ($result) {
            $rows = [];
            while ($row = $PDOStatement->fetch(PDO::FETCH_OBJ)) {
                $rows[] = $row;
            }

            return $rows;
        }

        return null;
    }
}
/*

PHP nos brinda como herramienta para gestionar bases de datos relacionales las clses PDO y PDOStatement.
Con esta herramienta podrémos utilizar en nuestro software una gran variedad de motores de bases de datos SQL muy comunes en la actualidad.
Estas clases cuentan con muchos metodos de alto nivel para ser usados para todo tipo de casos, aunque en este articulos solo nos enfocaremos en los metodos mas generales que nos permitiran resolver las acciones escenciales de gestión de datos

Pero para realizar operaciones a nuestra base de datos sugiero diferenciar entre consultas y comandos.

Las consultas son las operaciones de buscar y recuperar datos sin alterar nada en nustra base de datos.

Los comandos por otro lado son las operaciones que si realizan cambios en la base de datos, como las acciones de insertar datos nuevos y las acciones de modificar o eliminar datos existentes.

Hacer esta distinción es importante, primero porque es diferente la forma de trabajar con cada tipo de operación y segundo porque nos aporta mucho a la hora de crear un software mas mantenible, seguro y escalable

Separar entre operaciones de lectura y escritura en nuestro código nos permite crear piezas de software mas pequeñas, las cuales son mas fáciles de probar y mas faciles de mantener.

Para mejorar la seguridad en nuestro sofware podemos por ejemplo crear dos usuarios para gestionar nuestra base de datos, uno con los permisos normales para realizar todas las operaciones necesarias pero otro con permisos reducidos para ser usado por las piezas del sofware que unicamente requieran operaciones de lectura.
*/

/*
Para construir software escalable que en el futuro pueda soportar a miles de usuarios concurrentes, este se puede diseñar con dos bases de datos diferentes, una para las consultas y otra para los comandos, lo que da lugar al patrón de arquitectura llamado CQRS (Comand Query Responsability Segregation ó Separación de Responsabilidades de Comandos y Consultas en español) el cual permite trabajar con una base de datos optimizada y pensada para la lectura y otra optimizada solo para la escritura, y luego según sea el caso, escalar la base de datos que mejor le convenga a la aplicación
*/

/*
Antes de empezar a trabajar con bases de datos es necesario preparar una, primero instalando y configurando el motor si aún no lo tenemos, luego creando la base de datos y al menos un usuario con privilegios sobre esa base de datos.

Lo siguiente sería crear la estructura base que habŕa en esa base de datos, para esta guía usaremos una tabla para registrar productos, por lo que sería necesario correr el siguiente comando manualmente para así generar la tabla:

CREATE products IF NOT EXISTS(
    id bigserial not null primary key,
    code varchar(255) null unique,
    title varchar(255) null,
    price numeric(10, 2) not null default 0,
    stock integer not null default 0,
    active boolean not null default false,
    deleted_at timestamp(0) null
);
*/
/*
Ya con la base de datos preparada y con al menos una tabla creada ya podemos empezar a manejar la base de datos desde nuestro programa en PHP.

Para conectar a la base de datos hay que configurar la conexión, esto se hace directamente creando una instancia de la clase PDO.

Los argumentos que hay que pasarle a la clase PDO para generar objetos pueden variar dependiendo de la base de datos que se desa utilizar.

Para trabajar por ejemplo con SQLite, lo unico que hay que pasar como argumento es el camino hacia la ubicaión del archivo sqlite, mientras que para las demas bases de datos tendremos que pasar al menos 3 argumentos.
*/
/*
Un ejemplo sería
*/
$drive = 'pgsql';
$host = 'localhost';
$port = '5432';
$name = 'testdatabase';
$user = 'testuser';
$password = 'testpassword';

$dataSourceName = "$drive:host=$host;port=$port;dbname=$name";

$PDO = new PDO($dataSourceName, $user, $password);

/*
El primer argumento es una cadena de texto compuesta por el nombre del controlador de la base de datos, el servidor, el puerto y el nombre de la base de datos a los que hay que conectar
El segundo argumento es un nombre de usuario con permsisos para usar esta base de datos
Ell tercer argumento es la contraseña de ese usuario.
*/

/*
Una vez instanciado nuestro objeto PDO, ya podemos empezar a realizar operaciones con la base de datos.
*/

$query = 'SELECT id, code, title, price, stock FROM products';
$result = $PDO->query($query);
foreach ($result as $row) {
    echo "{$row['id']} - {$row['code']} - {$row['title']} - {$row['price']} - {$row['stock']}<br>";
}
/*
En teste bloque de código tenemos en la primera linea una cadena de texto que es el código SQL de la consulta que haremos a la base de datos.
En la segunda línea mandamos la consulta con PDO usando el metodo "query", el cual nos retornara un objecto que podemos recorrer con la estructura foreach en el que cada ciclo nos permitira acceder a una fila de los datos que nos retorne la consulta y esta fila es un arreglo asociativo, en el que cada elemento tiene el valor de una celda en nuestra tabla, y su clave es el nombre de la tabla.
Sabiendo esto es muy fácil directamente imprimir los datos o hacer otras operaciones con ellos.
*/

/*
Enviar nuevos registros a la base de datos

Ahora usaremos el metodo exec de PDO para poder enviar comandos, empezando con el comando de insertar un nuevo registro.
*/
$code = 70001;
$title = 'Producto demo #1';
$price = 200;
$stock = 15;

$command = "INSERT INTO products(code, title, price, stock) VALUES($code, '$title', $price, $stock)";
$PDO->exec($command); 

echo $PDO->lastInsertId();

/*
En este código definimos primero los datos del nuevo elemento a registrar en la base de datos, luego unimos esos datos en una sola cadena en la variable $command que representa el comando que finalmente enviaremos a la base de datos.

Por ultimo para saber si nuestro comando funciono y nuestro nuevo registro se guardo correctamente en la base de datos podemos usar el metodo lastInsertId, el cual nos retornara el Id de la fila que acabamos de registrar.

*/

/*
Insertando muchos datos al mismo tiempo

Si lo que queremos es insertar multiples nuevos registros de golpe, esto se puede lograr de la siguiente forma:

Este es el arreglo con los datos de lo selementos a insertar
*/
$products = [
    [
        'id' => null,
        'code' => 70001,
        'title' => 'Producto demo #1',
        'price' => 200,
        'stock' => 15,
    ],
    [
        'id' => null,
        'code' => 70001,
        'title' => 'Producto demo #2',
        'price' => 300,
        'stock' => 20,
    ],
    [
        'id' => null,
        'code' => 70001,
        'title' => 'Producto demo #3',
        'price' => 400,
        'stock' => 5,
    ],
];

foreach($products as $productKey => $productData){
    $command = "INSERT INTO products(code, title, price, stock) VALUES(
        {$productData['code']}, '{$productData['title']}', {$productData['price']}, {$productData['stock']}
    )";
    $PDO->exec($command);
    $products[$productKey]['id'] = $PDO->lastInsertId();
}

/*
La forma de eliminar registros es la siguiente:
*/
$command = "DELETE FROM products WHERE id = $id";
$PDO->exec($command);

/*
Solo se necesita enviar el comando de eliminacion definiendo las condiciones adecuadas para así borrar registros de forma permanente.
Si se requiere eliminar multiples registros se puede enviar el comando repetidamente usando estructuras repetitivas o se pueden definir condiciones que abarquen multiples filas.
*/

/*
Actualización de datos

Para enviar el comando de actualización de datos es tan simple como definir la sentencia sql y executarla con PDO exec.
*/
$command = "UPDATE products set stock = $stock WHERE id = $id";
$PDO->exec($command);
/*
Siempŕe será necesario revisar la condicion de la sentencia SQL para evitar modificar registros que no se tenga pensado modificar.
*/

/*
Como se puede mejorar la opoeración de actualización?

Con PHP podemos crear todo tipo de algoritmos que nos permitan realizar las operaciones con la base de datos de forma mas comoda y autonmatica.

Que haríamos si por ejemplo necesitamos editar mas de un campo a la vez? que tal si se tratara de cinco, diez o treinta campos?
Pues para eso nos conviene mejor crear una funcion que nos ayude a hacer las actualizaciones a la base de de una forma un poco mas comoda:
*/
function dataBaseUpdate(\PDO $PDO, string $table, array $fields)
{
    $id = $fields['id'];
    unset($fields['id']);

    $updateList = [];
    foreach ($fields as $field => $value) {
        $updateList[] = "$field = $value";
    }
    $fieldsToUpdate = implode(', ', $updateList);

    $command = "UPDATE $table SET $fieldsToUpdate WHERE id = $id";
    return $PDO->exec($command);
}

/*
Esta funcion nos ayuda a construir la sentencia SQL para actualizar datos (los que sean y en cualquier tabla), solo necesitamos darle como argumentos de entrada el objeto PDO de nuestra conexión a la base de datos, el nombre de la tabla que contiene los datos y los datos de los campos a editar, pero entre los campos debemos proporcionar el id de la fila a editar, de lo contrario el algoritmo se rompera.

Con esto podemos llevar a cabo el siguiente código para actualizar registros:
*/
dataBaseUpdate($PDO, 'products', [
    'id' => 4,
    'stock' => 3,
]);
dataBaseUpdate($PDO, 'products', [
    'id' => 5,
    'title' => "'Producto actualizado'",
    'price' => 300,
    'stock' => 14,
    'active' => true,
]);

/*
La primera instrucción actualizara la fila 4 de nuestra tabla de productos, cambiando el valor del stock por un 3.
La siguiente instrucción actualizara la fila 5, cambiando multiples campos de la fila al mismo tiempo (titulo, precio, stock, estado).

Hay que prestar atención que la cadena de texto que representa el titulo esta entre comillado, esto es porque las primeras comillas son para decirle a PHP donde acaba y termina el código y empieza el texto, y una vez que el texto sea contactenado a la sentencia SQL, se perderan estas comillas, pero en la sentencia de nuevo debemos indicar que es ćodigo SQL y que es texto humano, por lo que es necesario usar doble entre comillado para estos casos, y no podemos usar cualquier tipo de comillas, Postgres SQL por ejemplo, solo admite comillas simples para delimitar texto humano.

Y si en vez de realizar un numero finito de actualizaciones tuviesemos que actualizar un gran listado de filas?
Para ello podemos de neuvo recurrir a las estructuras repetitivas, por ejmeplo:
*/
$products = [
    [
        'id' => 3,
        'stock' => 7,
    ],
    [
        'id' => 4,
        'stock' => 3,
    ],
    [
        'id' => 5,
        'stock' => 14,
    ],
    // ... 
];
foreach($products as $product){
    dataBaseUpdate($PDO, 'products', $product);
}


$PDOStatement = $PDO->prepare($query);
$PDOStatement->execute($params);


$PDOStatement->fetch(PDO::FETCH_OBJ);

$PDO->beginTransaction();
$PDO->commit();
$PDO->rollBack();


// Database conexion
$PDO = new PDO("$drive:host=$host;port=$port;dbname=$name", $user, $password);

// Create database schema
$PDO->prepare($query)->execute();

// Read data
$PDOStatement = $PDO->prepare($query);
$rows = [];
if ($PDOStatement->execute($params)) {
    while ($row = $PDOStatement->fetch(PDO::FETCH_OBJ)) {
        $rows[] = $row;
    }
}

// Create data
$PDO->prepare($query)->execute($params);
$PDO->lastInsertId();

// Update data
$PDO->prepare($query)->execute($params);

// Delete data
$PDO->prepare($query)->execute($params);



$PDO->prepare($query)->execute();

$query = "INSERT INTO products(code, title, price, active) VALUES($code, $title, $price, $active)";