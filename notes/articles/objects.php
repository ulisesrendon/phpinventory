<?php

/*

https://kevinsmith.io/sanitize-your-inputs/

https://medium.com/@i.vikash/software-design-principles-building-a-solid-foundation-for-your-code-8ad92987f7d9
https://medium.com/@i.vikash/difference-between-cohesion-and-coupling-with-real-life-example-fc367034da00

<h1>Introducción a los objetos en PHP</h1>

Los objetos son estructuras que permiten encapsular y agrupar datos y su comportamiento, ocultando los detalles mas complejos y solo exponiendo los detalles necesarios promoviendo la abstracción y la modularidad.

<p>La principal forma de definir objetos en PHP es mediante unas estructuras especiales llamadas clases.</p>

<p>Las <strong>clases</strong> son los planos donde se detallan las características de los objetos, y con solo definir una unica clase se pueden generar muchos objetos, por lo que son muy útiles para <strong>reutilizar código</strong>.</p>

<p>Generar objetos a partir de clases se conoce como <strong>instanciar</strong> y para llevarlo a cabo se usa la palabra clave de PHP <strong>new</strong></p>

<pre><code>
*/
class NombreDeLaClase{

}
$object = new NombreDeLaClase;
/*
</code></pre>

<p>Para entender como es que esto funciona tenemos que ilustrarlo con código que resuelva problemas reales.</p>

<p>Pensemos por ejemplo en un producto de una tienda en línea, este producto debería contar con los siguientes datos:</p>

<ul>
    <li>Titulo</li>
    <li>Precio</li>
    <li>Existencias</li>
    <li>Descripción</li>
</ul>

<p>Creemos una clase que represente esto:</p>

<pre><code>
class Product
{
    private string $title = 'Pasta dental';
    private string $description = 'Producto de higiene bucal';
    private float $price = 39.9;
    private int $stock = 4;
}

$Product = new Product;
</code></pre>

<p>Ahora tenemos una clase producto que agrupa y oculta sus datos, simplemente definimos una variable para cada dato requerido y declaramos el tipo de dato, y antes de cada variable usamos la palabra <strong>private</strong> que es el indicativo de que el dato debe estar oculto y asi evitar que pueda ser accedido desde el exterior del objeto.</p>

<p>Podríamos haber definido un arreglo asociativo con estos datos, pero ¿como evitas que los datos sean modificados por tus algoritmos o por otros módulos?, ó ¿como evitas que los valores que van a ser modificados no se corrompan?</p>

<p>En el caso de un producto de una plataforma de comercio, el titulo y la descripción son valores que no suelen cambiar durante la ejecución del programa.</p>

<p>Por otro lado el precio es un valor que podría variar si se aplican impuestos o descuentos pero tanto el precio como las existencias son valores que de ser modificados tendrían que seguir algún criterio, como el de nunca poder ser valores negativos.</p>

<p>Para resolver estas cuestiones crearemos las funciones que definirán el comportamiento interno del producto, pero antes necesitamos aclarar ciertos detalles técnicos.</p>

<h2>Propiedades, métodos y su visibilidad</h2>

<p>Para poder declarar el comportamiento de un objeto se usa la forma que ya vimos antes para <a href="https://neuralpin.com/php/funciones">declarar funciones en PHP</a>, solo que ahora estas funciones estarán dentro de las llaves que delimitan la clase.</p>

<p>Y para permitir que estas funciones de clase puedan ser accedidas desde fuera del objeto las declaremos usando la palabra reservada <strong>public</strong></p>

<div class="li-note">
<p>Los modificadores de visibilidad Public y Private se usan para controlar el nivel de acceso a los miembros de un objeto.</p>

<p>Cuando queremos permitir que estos <strong>"miembros"</strong> puedan ser accedidas desde fuera del objeto, estos se declaran usando la palabra reservada <strong>public</strong> y si por el contrario quisiéramos que estén ocultos y que no puedan ser accedidos desde el exterior del objeto se usa la palabra clave <strong>private</strong>.</p>
</div>

<p>Para poder acceder a las propiedades o métodos de un objeto desde dentro del mismo objeto se usa una pseudovariable llamada <strong>$this</strong>, la cual es un comodín que hace referencia al propio objeto y sus miembros.</p>

<p>Para poder hacer referencia a cualquiera de los miembros de un objeto se usa el <strong>operador de objeto</strong> <mark>-&gt;</mark> (Operador flecha simple) que se construye con un guión medio y el símbolo "mayor que".</p>

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
echo '&lt;div&gt;
    &lt;h4&gt;'.$Product->getTitle().'&lt;/h4&gt;
    &lt;p&gt;'.$Product->getDescription().'&lt;/p&gt;
    &lt;p&gt;Precio: $'.$Product->getPrice().'&lt;/p&gt;
    &lt;p&gt;Existencias: '.$Product->getStock().'&lt;/p&gt;
&lt;/div&gt;';
/*</code></pre>

<div class="code-sample" data-url="objetos-ejemplo-1.php">
    &lt;div&gt;
        &lt;h4&gt;Pasta dental&lt;/h4&gt;
        &lt;p&gt;Producto de higiene bucal&lt;/p&gt;
        &lt;p&gt;Precio: $39.9}&lt;/p&gt;
        &lt;p&gt;Existencias: 4&lt;/p&gt;
    &lt;/div&gt;
</div>

<p>Hasta aquí pudiera parecer que con clases y objetos estamos haciendo varios pasos extra e innecesarios para poder hacer algo que con simples variables o con un arreglo asociativo podríamos haber hecho en menos lineas de código</p>

<p>Recordemos que una de las razones principales para usar la programación orientada a objetos (POO) es el ocultamento con el que  <strong>protegemos la integridad de los datos</strong>,</p>, si prestamos atención al código veremos que no hay forma de modificar los valores del producto mientras se ejecuta el programa.</p>

<p>Un problema del código escrito es que solo esta definido para un único producto, pero otra de las razones por las que usamos POO es por la facilidad que nos da para reutilizar código, por lo que ahora veremos como generar multiples objetos con el mismo código.</p>

<h2>Constructores de objetos</h2>

<p></p>




<p>Hay dos maneras para crear objetos, una de ellas es la de convertir arreglos en objetos, pero de esta forma no podemos controlar el ocultamiento y el encapsulamiento.</p>

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

*/


