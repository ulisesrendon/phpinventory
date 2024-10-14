
# <h1>Cómo Separar y Organizar el Código</h1>

<!-- 
https://kevinsmith.io/modern-php-without-a-framework/
https://dev.to/anwar_sadat/mastering-php-file-paths-simplifying-your-projects-structure-650
https://www.nikolaposa.in.rs/blog/2017/01/16/on-structuring-php-projects/


https://medium.com/@i.vikash/common-trade-offs-in-software-development-13d6f322e83b

https://medium.com/@i.vikash/unlocking-architectural-patterns-real-life-examples-for-easy-understanding-9f7661689f79
https://medium.com/@i.vikash/understanding-the-building-blocks-architectural-styles-vs-ac84d934f233
https://medium.com/@i.vikash/design-patterns-in-everyday-life-when-did-you-use-one-today-98ab74456ce6

https://medium.com/@i.vikash/the-positive-and-negative-aspects-of-chatgpt-for-me-as-a-software-developers-48e5c653c43a


https://medium.com/@i.vikash/understanding-malware-exploring-the-world-of-cyber-threats-9ad2182d94b1
https://medium.com/@i.vikash/protecting-the-cloud-common-malware-entry-points-dcf1869e5086
-->

Como dividir el código en archivos y directorios para generar una arquitectura practica que facilite hacer cambios y mantener todo en orden. 

<p>Conforme van creciendo las funcionalidades de nuestro software cada vez tendremos más líneas de código y no es para nada recomendable sumar miles de líneas en un solo archivo.</p>

<p>Por ello es recomendable desde un inicio ir dividiendo nuestro software en partes mas pequeñas y modulares.</p>

<p>También esta la opción de que necesitemos usar módulos creados por otras personas, por lo que es muy útil que nuestro código desde un inicio sea compatible con código de terceros.</p>

<p>Hay muchas formas diferentes de crear directorios para organizar los módulos de nuestro software, y hay varias formas de cortar archivos grandes en rebanadas mas pequeñas y crear así módulos más pequeños.</p>

<p>Afortunadamente PHP es muy flexible a la hora de permitirnos armar un software compuesto de múltiples módulos.</p>

<div class="li-note">Recordemos que un módulo puede ser cualquier cosa, desde un archivo con unas cuantas variables o constantes (Pueden ser archivos de configuración, paquetes de idioma, valores por defecto, datos estáticos que no cambiaran, etc.) hasta uno o multiples archivos que contienen una o multiples estructuras.</div>

<h2>Aprendamos a organizar el código</h2>

<p>Para cortar nuestro código en rebanadas modulares lo primero será plantearnos que estructura de directorios deberíamos manejar.</p>

<p>Lo mejor será siempre tener los directorios con nombres claros y mantener una estructura simple de forma que la arquitectura del proyecto sea tan clara que grite de que se trata cada cosa.</p>

<p>Aunque no siempre será posible dejarlo tan claro, por ejemplo al decidir implementar algún framework o al empezar a trabajar en un proyecto ya existente, estos ya cuentan con estructuras predefinidas y muchas veces es poco clara y poco flexible.</p>

<div class="li-note">
    <p>Un <mark>Framework</mark> es una colección de piezas de software reutilizables que se emplean para ser mas eficientes a la hora de desarrollar.</p>
</div>


<h3>Separación por conceptos y por capas</h3>

<p>La idea general que se aplica a la mayoría de proyectos es la de separar las piezas del software en al menos 4 conceptos:</p>

<ul>
    <li>Módulos internos del programa en cuestión</li>
    <li>Configuración</li>
    <li>Framework e Infraestructura</li>
    <li>Módulos de terceros</li>
</ul>

<p>Luego ya cada proyecto define varias capas extra para separar en aún mas conceptos los módulos internos del programa. Las capas en las que se suelen separar serían:</p>

<ul>
    <li>Capa de dominio</li>
    <li>Capa de datos</li>
    <li>Capa de presentación</li>
</ul>

<p>La capa de dominio es donde viven las reglas que gobiernan el comportamiento y funcionalidades del software.</p>

<p>Al ser esta capa el núcleo de un software, es la parte que conlleva mas mantenimiento y la que mas evoluciona y va cambiando conforme nacen nuevos requerimientos, por lo que identificar y separar los elementos de esta capa del resto de capas es muy importante.</p>


<h3>Estructura de directorios base</h3>

<p>Basándonos en todo esto veamos cual sería una estructura base recomendada para los directorios de una aplicación en PHP:</p>

<pre><code>config/ # Archivos de configuración
public/ # Archivos visibles desde internet
    index.php # Puerta de acceso a nuestra aplicación
src/ # Código fuente de la aplicación
vendor/ # Módulos de terceros</code></pre>

<p>Esta estructura de directorios podría parecer rara de momento pero con el tiempo la normalizaremos y en un inicio no parece que se relacione directamente con la separación por conceptos que mencionamos, pero aún falta añadir el resto de conceptos y explicar que propósito cumple cada directorio.</p>

<p>Con el directorio config creo que esta muy claro que clase de archivos agregaremos ahí.</p>

<p>El directorio public es donde colocamos archivos estáticos normales de una web como: css, js, html, imágenes, etc.</p>

<p>Por seguridad debemos bloquear el acceso a los archivos PHP de nuestro software, por ello es común encontrar en la carpeta public un archivo index.php con la lógica para servir como puerta de entrada a la aplicación, y el servidor web se configura para enviar todas las peticiones a se archivo.</p>

<p>El directorio vendor es el lugar donde el gestor de paquetes de PHP (Composer) normalmente descarga los módulos de terceros, aunque también podemos configurar el gestor para que descargue módulos que nosotros mismos hayamos creado.</p>

<p>La carpeta src es la que contendrá el núcleo de la aplicación, dentro crearemos los directorios necesarios para ayudarnos a organizar el dominio de nuestro software, y hay varias formas de hacerlo.</p>


<h3>Añadiendo el resto de conceptos a la estructura</h3>

<p>La forma con la que encontraremos muchos proyectos, sobre todo los que funcionan con frameworks de terceros es la que dentro del directorio principal inmediatamente añaden directorios extra para el resto de capas, dando una estructura como la siguiente: </p>

<pre><code>config/ # Archivos de configuración
public/ # Archivos visibles desde internet
    index.php # Puerta de acceso a nuestra aplicación
src/ # Código fuente de la aplicación
    controllers/ # Código que comunica los datos con la interfaz de usuario
    models/ # Código que gestiona los datos
    views/  # Código que genera la interfaz de usuario
vendor/ # Módulos de terceros</code></pre>

<p>Esta estructura esta bien para apps pequeñas, pero para software mas robusto y con muchos módulos internos no se recomienda esta estructura, lo recomendable sería crear un directorio por módulo y luego dentro de cada módulo hacer la separación por capas, dejándonos con una estructura parecida a la siguiente:</p>

<pre><code>config/ # Archivos de configuración
public/ # Archivos visibles desde internet
    index.php # Puerta de acceso a nuestra aplicación
src/ # Código fuente de la aplicación
    cart/
        controllers/ # Código que comunica los datos con la interfaz de usuario
        models/ # Código que gestiona los datos
        views/  # Código que genera la interfaz de usuario
    product/
        controllers/ # Código que comunica los datos con la interfaz de usuario
        models/ # Código que gestiona los datos
        views/  # Código que genera la interfaz de usuario
    user/
        controllers/ # Código que comunica los datos con la interfaz de usuario
        models/ # Código que gestiona los datos
        views/  # Código que genera la interfaz de usuario
vendor/ # Módulos con módulos creados por terceros</code></pre>

<h2>En resumen</h2>

<p>Cuando se empieza a trabajar en un proyecto existente se recomienda seguir el estilo del proyecto anterior.</p>

<p>Por lo que diseñar una buena estructura para el software desde el inicio ahorrara mucho tiempo en el futuro y agilizara el mantenimiento al permitir encontrar los archivos a modificar sin tanto esfuerzo y de forma intuitiva y al indicar cual debe ser la arquitectura para nuevos módulos.</p>

<p>PHP nos da la libertad de poder crear cualquier estructura que nos parezca conveniente, pero hay que pensar bien en cual escoger.</p>

<p>Recuerda no mezclar conceptos y mantener todo lo mas modular posible, siguiendo las buenas practicas del desarrollo de software y de la programación orientada a objetos.</p>

<!--
<p>Veamos mediante un ejemplo simple como hacer una ruptura de código Supongamos que tenemos un archivo que empieza a volverse una enorme pila de código:</p>

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

class DatabaseAccessLayer{
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
}
class UserController
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
-->