<!-- 
https://kevinsmith.io/sanitize-your-inputs/

https://medium.com/@i.vikash/software-design-principles-building-a-solid-foundation-for-your-code-8ad92987f7d9

https://medium.com/@i.vikash/difference-between-cohesion-and-coupling-with-real-life-example-fc367034da00

https://kevinsmith.io/whats-so-great-about-oop/

https://www.simplilearn.com/tutorials/php-tutorial/oops-in-php
-->

# Introducción a los objetos en PHP

Los objetos son estructuras que permiten encapsular y agrupar datos y su comportamiento, ocultando los detalles mas complejos y solo exponiendo los detalles necesarios, promoviendo la abstracción y la modularidad.

<p>La principal forma de definir objetos en PHP es mediante unas estructuras especiales llamadas clases.</p>

<p>Las <strong>clases</strong> son los planos donde se detallan las características de los objetos, y con solo definir una unica clase se pueden generar muchos objetos, por lo que son muy útiles para <strong>reutilizar código</strong>.</p>

<p>Generar objetos a partir de clases se conoce como <strong>instanciar</strong> y para llevarlo a cabo se usa la palabra clave de PHP <strong>new</strong></p>

```php
class NombreDeLaClase{
}
$object = new NombreDeLaClase;
```

<p>Para entender como es que esto funciona tenemos que ilustrarlo con código que resuelva problemas reales.</p>

<p>Pensemos por ejemplo en un producto de una tienda en línea, este producto debería contar con los siguientes datos:</p>

<ul>
    <li>Titulo</li>
    <li>Precio</li>
    <li>Existencias</li>
    <li>Descripción</li>
</ul>

<p>Creemos una clase que represente esto:</p>

```php
class Product
{
    private string $title = 'Pasta dental';
    private string $description = 'Producto de higiene bucal';
    private float $price = 39.9;
    private int $stock = 4;
}

$Product = new Product;
```

<p>Ahora tenemos una clase producto que agrupa y oculta sus datos, simplemente definimos una variable para cada dato requerido y declaramos el tipo de dato.
</p>

<p>Antes de cada variable usamos la palabra <strong>private</strong> que es el indicativo de que el dato debe estar oculto y asi evitar que pueda ser accedido desde el exterior del objeto.</p>

<p>Podríamos haber definido un arreglo asociativo con estos datos, pero ¿como evitas que los datos sean modificados por tus algoritmos o por otros módulos?, ó ¿como evitas que los valores que sí van a ser modificados no se corrompan?</p>

<p>En el caso de un producto de una plataforma de comercio, el titulo y la descripción son valores que no suelen cambiar durante la ejecución del programa.</p>

<p>Por otro lado el precio es un valor que podría variar si se aplican impuestos o descuentos pero tanto el precio como las existencias son valores que de ser modificados tendrían que seguir algún criterio (como el de nunca poder ser valores negativos por ejemplo).</p>

<p>Para resolver estas cuestiones crearemos las funciones que definirán el comportamiento interno del producto, pero antes necesitamos aclarar ciertos detalles técnicos.</p>


<h2>Propiedades, Métodos y su Visibilidad/Ocultamiento</h2>

<p>Las propiedades de un objeto es como se conoce a las variables que definimos dentro de una clase para contener los valores principales de un objeto.</p>

<p>Los métodos de una objeto son las funciones que definiremos dentro de una clase para programar el comportamiento de dichos objetos y se declaran usando el formato que ya vimos para <a href="https://neuralpin.com/php/funciones">declarar funciones en PHP</a>.</p>

<p>En conjunto las propiedades y métodos de un objeto es lo que se conoce como miembros de un objeto.</p>

<p>Y para controlar el nivel de ocultamiento de los miembros de un objeto se usan los modificadores de visibilidad <strong>Public</strong> y <strong>Private</strong> y con ellos se controla que puede o no ser accedido desde fuera del objeto.</p>

<p>Lo mas recomendable es por defecto definir todos los miembros como ocultos y solo definir como visibles desde el exterior a ciertos miembros en particular.</p>

<p>Estos miembros accesibles desde el exterior representan la interfaz del objeto (la superficie de contacto), y son el medio que usarán otros objetos y el resto del software para interactuar con ellos.</p>


<h2>Encapsulamiento</h2>

<p>Los miembros de un objeto están aislados del resto de cosas del programa, pero no están aislados entre si, ya que forman parte de la misma unidad estos pueden interactuar entre sí.</p>

<p>A esta característica de los objetos de permitir que sus elementos internos puedan referenciarse entre ellos se le llama encapsulamiento.</p>

<p>Para poder hacer referencia a las propiedades o métodos de un objeto desde dentro del mismo se usa una pseudovariable llamada <strong>$this</strong>, la cual es un comodín que hace referencia al propio objeto.</p>

<p>Este comodín se usa en conjunto con el <strong>operador de objeto</strong> <mark>-&gt;</mark> (Operador flecha simple, el cual se construye con un "guión medio" y el símbolo "mayor que") para realizar esta interacción entre los miembros de un objeto <strong>$this-></strong>.</p>



<h2>Acceso a las Propiedades del objeto vía Getters</h2>

<p>Los Getters son funciones pensados para permitir la lectura de los valores internos de un objeto de forma controlada, se suelen llamar con el nombre de la propiedad que se desea leer pero precedida por el prefijo <strong>get</strong>, por ejemplo getTitle(), getPrice(), getStock(), etc.</p>


<h2>Poniendo en practica lo aprendido</h2>

<p>Vamos a modificar el código de la clase producto y añadiremos los mecanismos para poder leer los datos internos del producto
y al final del código vamos a llamarlos para comprobar que realmente estamos accediendo a la información correcta.</p>

```php
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
```

```html
<div class="code-sample" data-url="objetos-ejemplo-1.php">
    &lt;div&gt;
        &lt;h4&gt;Pasta dental&lt;/h4&gt;
        &lt;p&gt;Producto de higiene bucal&lt;/p&gt;
        &lt;p&gt;Precio: $39.9&lt;/p&gt;
        &lt;p&gt;Existencias: 4&lt;/p&gt;
    &lt;/div&gt;
</div>
```

<p>Hemos definido una función getter para cada propiedad de nuestro objeto y hemos dejado estos métodos como públicos para permitir su acceso fuera del objeto.</p>

<p>Dentro de cada getter usamos la referencia al objeto contenedor y el operador flecha <strong>$this-></strong> para poder acceder a cada una de las propiedades.</p>

<p>Con todo esto logramos encapsular los datos de un producto de forma que no haya forma de modificar sus valores, solo tenemos mecanismos para poder leer dichos datos.</p>

<p>Usando solo arreglos, constantes y funciones podemos emular todos estos comportamientos y conceptos, pero definitivamente no es sencillo, y el código resultante no sería tan compacto como el que nos permite generar la Programación Orientada a Objetos.</p>

<p>Aunque un problema del código que llevamos escrito hasta aquí es que solo esta definido para un único producto, pero otra de las razones por las que usamos POO es por la facilidad que nos da para reutilizar código, por lo que ahora veremos como generar multiples objetos con el mismo código.</p>


<h2>Constructores de objetos</h2>

<p>Dentro de cada clase podemos definir un método especial conocido como constructor, y este nos permite proporcionarle a la clase los valores base con los que se creara cada objeto.</p>

<p>Este método especial no puede tener cualquier nombre, en concreto en PHP debe ser una función con el nombre <strong>__construct</strong> y solo puede llevar el modificador de visibilidad <strong>public</strong>.</p>

<p>A nuestro constructor podemos definirle argumentos de función como a cualquier otra función convencional</p>

<p>Al estar dicho método especial encapsulado en una clase, podemos interactuar con el resto de miembros del objeto, por lo que tomaremos los argumentos de la función y directamente los asignaremos a propiedades del objeto.</p>

<p>De esta forma podemos usar la misma clase para crear multiples objetos con valores diferentes pero reutilizando el mismo plano, permitiendo de forma elegante reutilizar grandes cantidades de código para crear estructuras similares.</p>

<p>Modifiquemos nuestra clase Producto para añadir un constructor con un argumento por cada propiedad del objeto.</p>

```php
class Product
{
    private string $title;
    private string $description;
    private float $price;
    private int $stock;

    public function __construct(
        string $title,
        string $description,
        float $price,
        int $stock,
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
    }

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
```

<p>Para usar la clase emplearemos ahora una lista de productos, los cuales podrían ser leídos de alguna base de datos o proporcionados por una interfaz de usuario.</p>

<p>Luego esa lista de productos la recorreremos con un bucle foreach y crearemos un objeto por cada producto.</p>

```php
$items = [
    [
        'title' => 'Pasta dental',
        'description' => 'Producto de higiene bucal',
        'price' => 39.9,
        'stock' => 4,
    ],
    [
        'title' => 'Crema corporal humectante',
        'description' => 'Producto dermatológico',
        'price' => 50.2
        'stock' => 6,
    ],
    [
        'title' => 'Protector Solar 50+fps',
        'description' => 'Protector solar facial',
        'price' => 50.2
        'stock' => 10,
    ],
    [
        'title' => 'Aspirina',
        'description' => 'Tableta ácido acetilsalicílico',
        'price' => 57
        'stock' => 12,
    ],
    [
        'title' => 'Enjuague bucal',
        'description' => 'Producto de higiene bucal',
        'price' => 57
        'stock' => 12,
    ],
];

$ProductList = [];
foreach($items as $item){
    $ProductList[] = new Product(
        $item['title'],
        $item['description'],
        $item['price'],
        $item['stock'],
    );
}
```

<p>Con esto ya tendríamos un listado de objetos, que de momento solo es un conjunto de datos donde todos comparten el mismo comportamiento, lo cual de momento puede parecer mucho código para lo que realmente sirve.</p>

<p>Para cambiar un poco esto y empezar a tener noción del potencial de la POO modifiquemos nuestro ejemplo añadiendo más lógica para una situación común.</p>

<p>Para actualizar el comportamiento de todos nuestros objetos tipo producto solo hace falta modificar una sola pieza del software, que en este caso es la clase Product.</p>

<p>Si tuviésemos que aplicar un impuesto al precio de los productos en la misma clase podríamos definir en una constante de clase cual es el impuesto fijo a aplicar por ejemplo, o si necesitáramos un método para imprimir la lista de productos en cierto formato </p>



```php
class Product
{
    const 
    private string $title;
    private string $description;
    private float $price;
    private int $stock;

    public function __construct(
        string $title,
        string $description,
        float $price,
        int $stock,
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
    }

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
```
<h2>En resumen</h2>

<p>Con esto ya tenemos la sintaxis básica para trabajar con objetos en PHP, ya que ahora conocemos las clases, que son los planos que definen y permiten crear objetos y como se definen las propiedades y los métodos dentro de ellas.</p>

<!-- 
Base de datos, Fechas, peticiones http
<p>Hay dos maneras para crear objetos, una de ellas es la de convertir arreglos en objetos, pero de esta forma no podemos controlar el ocultamiento y el encapsulamiento.</p>

<p>Mostrar solo los detalles mas importantes de las cosas y ocultar el resto facilita la abstracción de ideas.</p>

<p>Con los objetos podemos representar conceptos reales o imaginarios de forma abstracta.</p>

<p>Con todo esto ya no es necesario solo pensar en datos numéricos que representan precios y cantidades o en textos que representan nombres, correos, contraseñas, títulos, descripciones, etc</p>

<p>Ahora cambiamos el enfoque y pensamos en clientes, productos, carritos de compra, ordenes, etc.</p>

<p>Esto es la programación orientada a objetos, un paradigma en el que se mezclan los datos y su comportamiento para dar lugar a estructuras mas complejas</p>

<p>Estas estructuras, aunque mas complejas, permiten de forma abstracta representar ideas y conceptos de la vida real, los cuales se pueden discutir, planear y documentar más fácilmente antes de pasar a su implementación en código.</p>


<p>Una entidad es un concepto de alguna cosa del mundo real que representada en un objeto de la programación este se puede distinguido de los demás objetos</p>


<p>Mediante clases se define una interfaz para detallar como se puede interactuar con un objeto en particular</p>

-->