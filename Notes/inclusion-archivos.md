
# <h1>Separar, organizar y usar código en multiples archivos</h1>

https://dev.to/anwar_sadat/mastering-php-file-paths-simplifying-your-projects-structure-650


https://www.nikolaposa.in.rs/blog/2017/01/16/on-structuring-php-projects/

Como usar la inclusión de archivos para mantener el código organizado, modular y mantenible

```html
<p>Conforme van creciendo las funcionalidades de nuestro software cada vez tendremos más líneas de código y no es para nada recomendable sumar miles de líneas en un solo archivo, por lo que es necesario desde un inicio estar preparados para dividir nuestro software en partes mas pequeñas y modulares.</p>

<p>También esta la opción de que necesitemos usar módulos creados por otras personas, por lo que será necesario que nuestro código desde un inicio sea compatible con código de terceros.</p>

<p>Hay muchas formas diferentes de crear directorios para organizar los módulos de nuestro software, y hay varias formas de cortar archivos grandes en rebanadas mas pequeñas y crear así módulos más pequeños.</p>

<p>Un módulo puede ser cualquier cosa, desde un archivo con unas cuantas variables o constantes (Pueden ser archivos de configuración, paquetes de idioma, valores por defecto, datos estáticos que no cambiaran, etc.) hasta uno o multiples archivos que contienen una o multiples estructuras.</p>

<p>Afortunadamente PHP es muy flexible a la hora de permitirnos armar un software compuesto de múltiples módulos.</p>

<p>Veamos mediante un ejemplo simple como hacer una ruptura de código Supongamos que tenemos un archivo que empieza a volverse una enorme pila de código:</p>
```
```php
<?php
const AVAILABLE_COUNTRIES = [
    'eu' => 'Estados Unidos',
    'mx' => 'México',
    'ar' => 'Argentina',
    // ...
];
const AVAILABLE_TAXES = [
    'tax1' => 0.16,
    'tax2' => 0.08,
    // ...
];
const MAX_LOGIN_ATTEMPTS = 10;
const MAX_USERNAME_CHARACTERS = 16;

const PRODUCTS_PER_PAGE = 20;
function databaseConnection($args)
{
    // Código para conectar con la base de datos
}
function databaseSendCommands($args)
{
    // Código para enviar comandos a la base de datos
}
function databaseSendQuery($args)
{
    // Código para solicitar datos de la base de datos
}
function userController($args)
{
    // Código para controlar rutas de los usuarios
}
function userSignIn($args)
{
    // Código para inicio de sesión
}
function userSignOut($args)
{
    // Código para cierre de sesión
}
function userSignUp($args)
{
    // Código para registro de usuarios
}
function viewSignForm($args)
{
    // Código para mostrar pantalla de acceso
}
function ecommerceController($args)
{
    // Código para controlar rutas de los usuarios
}
function productSearch($args)
{
    // Código para búsqueda de productos
}
function cartAddProduct($args)
{
    // Código para añadir productos al carrito
}
function viewReportProductSales($args)
{
    // Código para mostrar pantalla con datos de ventas
}
```

```html
<p>Para cortar este código en rebanadas modulares lo primero será plantearnos que estructura de directorios deberíamos manejar.</p>

<p>Lo mejor será siempre tener los directorios con nombres claros y una estructura simple de manera que la arquitectura del proyecto grite de que se trata cada cosa.</p>

<p>Aunque no siempre será posible, por ejemplo al decidir implementar algún framework poco flexible o al empezar a trabajar en un proyecto que ya tenga su propia estructura predefinida (muchas veces dictadas for Frameworks)</p>

<p>La idea general que aplica al menos a la mayoría de proyectos es la de separar las piezas del software en 4 conceptos:</p>

<ul>
    <li>Configuración</li>
    <li>Framework</li>
    <li>Módulos de terceros</li>
    <li>Módulos internos del programa en cuestión</li>
</ul>

<p>Los frameworks y otros proyectos que algún día seguro te encontraras mantienen una estructura basada en estos conceptos principalmente y luego ya cada proyecto define varias capas extra para separar en aún mas conceptos los módulos internos del programa.</p>

<p>La separación en capas minima que tienen demás proyectos para los módulos internos del programa sería:</p>

<ul>
    <li>Capa de presentación</li>
    <li>Capa de datos</li>
    <li>Capa de dominio</li>
</ul>

<p>La capa de dominio es donde viven las reglas que gobiernan el comportamiento y funcionalidades del software</p>

<p></p>

```

```php
include 'dir/file1';
require 'dir/file2';
```