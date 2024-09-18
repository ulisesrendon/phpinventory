<?php

/*

<h1>Objetos en PHP</h1>

Los objetos son estructuras que permiten encapsular y agrupar datos y su comportamiento, ocultando los detalles mas complejos y solo exponiendo los detalles necesarios promoviendo la abstracción y la modularidad.

<div class="li-note">Aviso: Te adelanto que trabajar con objetos es otro paradigma que puede que en un inicio se vea muy verboso y complicado, aún así te recomiendo fuertemente terminar de estudiar este apartado y te aseguro que con algo de paciencia se volverá más fácil y cómodo y te sera de mucha utilidad para poder resolver y gestionar problemas que con otros paradigmas sería mas complicado.</div>

<p>Cuando tenemos datos que están relacionados entre si podríamos optar por representarlos en forma de arreglo simple, arreglo asociativo o en forma de objeto.</p>

<p>¿Cuando se usa un arreglo simple o cuando se un arreglo asociativo?</p>

<p>Un arreglo simple será suficiente para representar información cuando esta tiene una forma secuencial que no necesita un orden en concreto o que basta con números enteros para darle orden (por ejemplo: los días de la semana, los meses del año, una lista de tareas, una lista de nombres, etc).</p>

<p>Los arreglos asociativos se usan con información que requiere una estructura u orden mas especifica</p>

<p>Mediante la forma clave => valor de un arreglo asociativo se puede llegar a estructuras muy complejas ya que podemos anidar arreglos libremente.</p>

<p>Los objetos son en esencia conjuntos de datos relacionados entre si y con los que se pueden formar todo tipo de estructuras, como las que formaríamos combinando arreglos asociativos.</p>

<h4>¿Cual es entonces la diferencia entre un objeto y un arreglo asociativo?</h4>

<p>Si el objetivo es generar estructuras de información para poder compartirlas con otros programas o mediante internet, no hay ninguna diferencia entre usar arreglos asociativos u objetos.</p>

<p>Al convertir datos de php a datos de otras tecnologías los arreglos asociativos se convierten en objetos de esas tecnologías y viceversa, al convertir datos de otras tecnologías a datos de php los datos de tipo objeto de otras tecnología se pueden convertir en arreglos asociativos de php.</p>

<h4>¿Entonces para que sirven los objetos de PHP? ó ¿Cuando debería usar dichos tipos de datos?</h4>

<p>Aunque en concepto y en su forma de transferir datos son lo mismo, un arreglo asociativo se diferencia de un objeto literal de PHP en que este ultimo cuenta con muchas mas características y funcionalidades, y a continuación veremos varias de esas características y veremos que problemas resuelve cada una.</p>

<h3>Encapsulamiento</h3>

<p>Un objeto literal de PHP no solo contiene datos, también puede definir comportamiento para esos datos.</p>

<p>Este comportamiento se crea a base de declarar funciones internas que operan con los datos del objeto y hacen referencia a estos pero entendiendo que dichos datos son parte de la misma unidad.</p>

<p>En un arreglo asociativo podemos sin problema declarar funciones como valores, pero dentro de esas funciones no hay forma de detectar que se está dentro de una estructura, es es complicado intentar acceder a los demás datos dentro de la misma estructura.</p>

<p>Por otro lado en los objetos tenemos el concepto de encapsulamiento, el cual es poder tratar los datos y funciones internos de un objeto como parte de una misma unidad y dentro de dicha unidad se permite referenciar de forma fácil a las demás partes del conjunto.</p>

<p>Los datos encapsulados en objetos pasan a llamarse <strong>atributos</strong> y las funciones que definen el comportamiento de esos datos pasan a llamarse <strong>métodos</strong></p>

<p>Los atributos y los métodos de un objeto se llaman en conjunto miembros.</p>


<h3>Ocultamiento</h3>

<p>Los objetos permiten de forma fácil controlar que datos pueden ser accedidos y modificados desde el exterior del objeto y cuales no.</p>

<p>Trabajando solo con arreglos asociativos no es fácil evitar que los datos que estos contienen puedan ser accedidos o modificados por otros módulos u otras partes del mismo algoritmo.</p>

<p>Tener un buen control del acceso a los datos de tu programa facilita el crear software mas seguro y robusto, ya que es mas fácil evitar errores por cambios inesperados en el estado de esos datos, ademas de que es más fácil hacer mantenimiento cuando puedes rastrear de forma clara que partes del código son las que acceden a los datos.</p>

<h3>Abstracción</h3>

<p>De la misma forma que se controla el acceso a los datos de un objeto se pueden ocultar las funcionalidades y así controlar que métodos pueden ser invocados desde cualquier parte del software y cuales están reservadas unicamente para ser usadas desde dentro del objeto.</p>

<p>Mostrar solo los detalles mas importantes de las cosas y ocultar el resto de detalles es lo que se conoce como abstracción.</p>

<p>Podemos representar conceptos e ideas de forma abstracta en nuestro código sin necesidad de usar objetos, pero con los objetos se vuelve mas claro, ya que literalmente podemos definir cuales son las funcionalidades visibles y palpables por el resto de módulos y partes del sistema.</p>


<h3>Polimorfismo</h3>

<p>A estas funcionalidades visibles y palpables de un objeto también se les conoce bajo el concepto de interfaces (superficie de contacto), y conociendo la interfaz que tiene un objeto podemos comunicarnos con el sin requerir muchos detalles de este.</p>

<p>Pensemos en un aparato que da la hora, sin saber como funciona internamente algún aparato con interfaz de reloj podemos interactuar con el, sin importar si se trata de un reloj de pared, o de muñeca, o si es digital o análogo o sin en realidad se trata de otro aparato como un smartphone o un teléfono que simplemente tienen esa funcionalidad de dar la hora.</p>

<p>Y por convención sabemos que un reloj debe primero dar la hora, si tiene un segundo valor o una segunda manecilla esta será para los minutos.</p>

<p>Si vemos que algo tiene forma de reloj esperamos que funcione como tal y nos permita consultar la hora actual, y si por el contrario vemos que esa cosa no nos da la hora actual sabemos que esta descompuesto.</p>

<p>A esta característica de poder tener cosas con diferentes formas y con diferentes funcionamientos internos pero que comparten una interfaz en común se le conoce en programación como <strong>Polimorfismo</strong></p>

<p>En programación antes de crear los objetos podemos pensar en ideas y conceptos de forma abstracta y luego planear que debería haber en la superficie de contacto de estos objetos y declarar convenciones de como deben ser usados y que se espera de ellos para finalmente codificar objetos que implementarán estas interfaces y definiciones</p>

<p>Luego podemos crear variaciones de estos mismos objetos o crear otros objetos completamente diferentes pero que respeten la misma interfaz.</p>

<p>Y así sin mucho problema podemos crear código modular y extendible, con partes completamente intercambiables, las cuales serán más fácil y transparentes de mantener</p>

<p>Ya que si intentamos cambiar algo o añadir código nuevo y este no respeta las reglas que definimos para la interfaz, el código ni siquiera correrá y PHP nos avisara de que hay una violación que debe ser reparada, y por el contrario si respetamos las interfaces el código funcionara como se espera</p>

<h3>Herencia</h3>

<p>Otra característica importante de la programación orientada a objetos es la opción de poder tomar código de objetos para crear definiciones nuevas que reutilicen total o parcialmente el código existente y crear con esto nuevas variaciones variaciones de objetos que cuenten con nuevas funcionalidades ó que cambien el comportamiento previamente establecido y solo respeten las interfaces.</p>

<p>A esta característica se le llama <strong>Herencia</strong> y aunque su comportamiento se puede emular en la programación sin tener que recurrir a objetos, con objetos lograr la herencia es extremadamente fácil.</p>

<h3>Modularidad</h3>

<p>La modularidad consiste en dividir tu programa en partes mas pequeñas con el fin de hacer mas claro y transparente su funcionamiento y con esto hacer más fácil el mantenimiento.</p>

<p>En PHP y en otros sistemas un módulo puede ser solo un archivo con apenas algo de código, y ese código no tendría precisamente porque ser un objeto.</p>

<p>Un modulo podría ser solo una función o un conjunto de variables o constantes, el punto es separar nuestro software en partes mas pequeñas.</p>

<p>Por su naturaleza los objetos tienden a ser modulares, y un software compuesto de multiples objetos puede ser fácilmente dividido en multiples archivos archivos con un objeto cada uno.</p>

<p>En PHP trabajar con objetos hace que la modularidad sea aún más fácil ya que al trabajar con estas estructuras podemos definir reglas simples para que el motor de PHP ensamble el software con los objetos necesarios según se van requiriendo.</p>



<p>La mejor forma y la principal forma de definir objetos es mediante clases.</p>

<p>Las clases son el plano en donde se detallan las características de los objetos y con solo una clase se pueden generar muchos objetos, por lo que son muy útiles para reutilizar código.</p>

<p>Para crear un objeto a partir de una clase se usa la palabra clave de PHP <strong>new</strong></p>

<pre><code>
*/
class NombreDeLaClase{

}
$object = new NombreDeLaClase;
/*
</code></pre>

<p>Para entender como funciona esto tenemos que ver algún ejemplo real.</p>

<p>Pensemos por ejemplo en un producto de una tienda en línea, este producto debería contar con los siguientes datos:</p>

<ul>
    <li>Titulo</li>
    <li>Precio</li>
    <li>Existencias</li>
    <li>Descripción</li>
</ul>

<p>Creemos una clase que represente esto:</p>

<pre><code>*/
class Product
{
    private string $title = 'Pasta dental';
    private string $description = 'Producto de higiene bucal';
    private float $price = 39.9;
    private int $stock = 4;
}

$Product = new Product;
/*</code></pre>

<p>Ahora tenemos una clase producto que agrupa y oculta sus datos, simplemente definimos una variable para cada dato requerido y declaramos el tipo de dato, y antes de cada variable usamos la palabra <strong>private</strong> que es el indicativo de que el dato debe estar oculto y asi evitar que pueda ser accedido desde el exterior del objeto.</p>

<p>Podríamos haber definido un arreglo asociativo con estos datos, pero ¿como evitas que los datos sean modificados por tus algoritmos o por otros módulos?, ó ¿como evitas que los valores que van a ser modificados no se corrompan?</p>

<p>En el caso de un producto de una plataforma de comercio, el titulo y la descripción son valores que no suelen cambiar durante la ejecución del programa.</p>

<p>Por otro lado el precio es un valor que podría variar si se aplican impuestos o descuentos pero tanto el precio como las existencias son valores que de ser modificados tendrían que seguir algún criterio, como el de nunca poder ser valores negativos.</p>

<p>Para resolver estas cuestiones crearemos las funciones que definirán el comportamiento interno del producto, pero antes necesitamos aclarar ciertos detalles técnicos.</p>

<h2>Propiedades y métodos y su visibilidad</h2>

<p>Para poder declarar el comportamiento de un objeto se usa el formato que ya vimos antes para declarar funciones, solo que ahora estas funciones estarán dentro de las llaves que delimitan la clase.</p>

<p>Y para permitir que estas funciones de clase puedan ser accedidas desde fuera del objeto las declaremos anteponiendoles la palabra reservada <strong>public</strong></p>

<div class="li-note">
<p>Public y private se usan para controlar el nivel de visibilidad de los miembros de un objeto.</p>

<p>Cuando queremos permitir que estos <strong>"miembros"</strong> puedan ser accedidas desde fuera del objeto, estos se declaran usando la palabra reservada <strong>public</strong> y si por el contrario quisiéramos que estén ocultos y que no puedan ser accedidos desde el exterior del objeto se usa la palabra clave <strong>private</strong>.</p>
</div>

<p>Para poder acceder a las propiedades o métodos de un objeto desde dentro del mismo objeto se usa una pseudovariable llamada <strong>$this</strong>, la cual es un comodín que hace referencia al propio objeto y sus miembros.</p>

<p>Para poder hacer referencia a cualquiera de los miembros de un objeto se usa el <strong>operador de objeto</strong> <mark>-></mark> (Operador flecha simple) que se construye con un guión medio y el símbolo "mayor que".</p>

<p>Aplicando todo lo anterior vamos a modificar el código del ejemplo anterior añadiendo los mecanismos para poder leer los datos del producto y al final del código vamos a imprimirlos para comprobar que realmente estamos accediendo a la información correcta.</p>

<pre><code>*/
class Product
{
    private string $title = 'Pasta dental';
    private string $description = 'Producto de higiene bucal';
    private float $price = 39.9;
    private int $stock = 4;

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getStock()
    {
        return $this->stock;
    }
}

$Product = new Product;
$title = $Product->getTitle();
$description = $Product->getDescription();
$price = $Product->getPrice();
$stock = $Product->getStock();

echo "&lt;div&gt;
    &lt;h4&gt;{$title}&lt;/h4&gt;
    &lt;p&gt;{$description}&lt;/p&gt;
    &lt;p&gt;Precio: \${$price}}&lt;/p&gt;
    &lt;p&gt;Existencias: {$stock}&lt;/p&gt;
&lt;/div&gt;";
/*</code></pre>

<div class="code-sample" data-url="objetos-ejemplo-1.php">
    &lt;div&gt;
        &lt;h4&gt;Pasta dental&lt;/h4&gt;
        &lt;p&gt;Producto de higiene bucal&lt;/p&gt;
        &lt;p&gt;Precio: $39.9}&lt;/p&gt;
        &lt;p&gt;Existencias: 4&lt;/p&gt;
    &lt;/div&gt;
</div>

<p>Hasta aquí pudiera parecer que con clases y objetos estamos haciendo varios pasos extra innecesarios para poder hacer algo que con simples variables o con un arreglo asociativo podríamos haber hecho en menos lineas de código.</p>

<p>Hay que recordar que hacemos todo esto para poder proteger los datos para que no sean modificados, si ponemos atención al código, no hay forma alguna de modificar los valores del producto mientras se ejecuta el programa.</p>



<p>Hay dos maneras para crear objetos, una de ellas es la de convertir arreglos en objetos, pero de esta forma no podemos controlar el ocultamiento y el encapsulamiento.</p>


<h2>Resumen de los objetos en PHP</h2>

<p>Los objectos permiten de forma fácil organizar y reutilizar código.</p>

<p>Permiten pasar de un montón de variables y funciones sueltas que podrían o no estar relacionados entre si a capsulas que agrupan datos y su comportamiento y que definen una interfaz que detalla la forma en la que los objectos se conectan e interactúan con otros objetos y otros módulos</p>

<p>Los objetos promueven el trabajar con abstracciones, que consiste en ocultar los detalles complejos y enfocarse solo en determinadas propiedades de las cosas.</p>

<p>Los objetos que comparten la misma interfaz pueden ser intercambiados entre si, esto facilita la modularidad y la reutilización de código</p>



<p>Mostrar solo los detalles mas importantes de las cosas y ocultar el resto facilita la abstracción de ideas.</p>

<p>Con los objetos podemos representar conceptos reales o imaginarios de forma abstracta.</p>

<p>Con todo esto ya no es necesario solo pensar en datos numéricos que representan precios y cantidades o en textos que representan nombres, correos, contraseñas, títulos, descripciones, etc</p>

<p>Ahora cambiamos el enfoque y pensamos en clientes, productos, carritos de compra, ordenes, etc.</p>

<p>Esto es la programación orientada a objetos, un paradigma en el que se mezclan los datos y su comportamiento para dar lugar a estructuras mas complejas</p>

<p>Estas estructuras, aunque mas complejas, permiten de forma abstracta representar ideas y conceptos de la vida real, los cuales se pueden discutir, planear y documentar más fácilmente antes de pasar a su implementación en código.</p>


<p>Una entidad es un concepto de alguna cosa del mundo real que representada en un objeto de la programación este se puede distinguido de los demás objetos</p>

<p>Los objetos no remplazan los arreglos</p>

<p>Las clases son planos de estructuras</p>

<p>Mediante clases se define una interfaz para detallar como se puede interactuar con un objeto en particular</p>



-Ocultamiento
-Encapsulamiento
-Abstracción

-Modularidad

-Polimorfismo
-Composición
-Herencia

*/


