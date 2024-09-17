<?php

/*

<h1>Objetos en PHP</h1>

Los objetos son estructuras que permiten encapsular y agrupar datos y su comportamiento, ocultando los detalles mas complejos y solo exponiendo los detalles necesarios promoviendo la abstracción y la reutilización de código.

<div class="li-note">Aviso: Te adelanto que trabajar con objetos es otro paradigma que puede que en un inicio se vea muy verboso y complicado, aún así te recomiendo fuertemente terminar de estudiar este apartado y te aseguro que con algo de paciencia se volverá más fácil y cómodo y te sera de mucha utilidad para poder resolver y gestionar problemas que con otros paradigmas sería mas complicado.</div>

<p>Los objectos son una forma de agrupar y trabajar con datos que están muy relacionados entre sí.</p>

<p>Y no solo permiten agruparlos, también permiten de forma fácil controlar que datos se pueden acceder y/o modificar y cuales no.</p>

<p>Esto se conoce como el principio de ocultamiento.</p>

<p>Los objetos también pueden agrupar funciones que están relacionadas entre sí o agrupar a las funciones que deben trabajar con el mismo conjunto de datos.</p>

<p>Esto es lo que se conoce como el principio de encapsulamiento, el poder tratar datos y funciones como parte de una misma unidad.</p>

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

<p>Los datos encapsulados en objetos se conocen como <strong>propiedades</strong> y las funciones encapsuladas en objectos se conocen como <strong>métodos</strong> y cuando para referirse a cualquiera de las dos cosas o a ambas en general se les conoce como <strong>miembros</strong></p>

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



<p>Como evitas que la información de tus algoritmos sea accedida o modificada por otros módulos u otras partes del mismo algoritmo?</p>
*/


