<h1>Programación Orientada a Objetos en PHP</h1>

La programación orientada a objetos es un paradigma en el que se encapsulan datos y su comportamiento para dar lugar a estructuras con las que se representa en código ideas y conceptos de forma abstracta

<div class="li-note">
    <p>Aviso: Te adelanto que trabajar con objetos es más que trabajar con una nueva sintaxis, la programación orientada a objetos es un cambio de paradigma.</p>
    <p>Puede que en un inicio se vea muy verboso y complicado, aún así te recomiendo fuertemente terminar de estudiar este apartado
    </p>
    <p>Te aseguramos que con algo de paciencia y practica este paradigma se volverá más fácil y cómodo y te sera de mucha utilidad para poder resolver y gestionar problemas que con otros paradigmas serían mas complicado.
    </p>
</div>

<p>La programación orientada a objetos es un paradigma que promueve la creación de estructuras modulares y reutilizables llamadas objetos y que encierran el comportamiento y los datos del software.</p>

<p>La idea principal de usar objetos en vez de otras estructuras es la de reducir la complejidad del código y mejorar su mantenibilidad y esto se logra creando piezas de software mas abstractas y cada una con una responsabilidad clara dentro del sistema.</p>

<p>La programación orientada a objetos es una forma especial de escribir código que cambia completamente la forma en la que pensamos y organizamos los algoritmos de nuestro software.</p>

<h2>Arreglos vs Objetos</h2>

<p>Los objetos a pesar de ser contenedores de datos no pueden remplazan a los arreglos directamente.</p>

<p>Cuando tenemos datos relacionados entre si podríamos optar por representarlos en forma de arreglo simple, arreglo asociativo o en forma de objeto.</p>

<h3>¿Cuando se usa un arreglo simple o cuando se un arreglo asociativo?</h3>

<p>Un arreglo simple será suficiente para representar información cuando esta tiene una forma secuencial que no necesita un orden en concreto o que basta con números enteros para darle orden (por ejemplo: los días de la semana, los meses del año, una lista de tareas, una lista de nombres, etc).</p>

<p>Los arreglos asociativos se usan con información que requiere una estructura u orden mas especifica</p>

<p>Mediante la forma clave => valor de un arreglo asociativo se puede llegar a estructuras muy complejas ya que podemos anidar arreglos libremente.</p>

<p>Los objetos son en esencia conjuntos de datos relacionados entre si y con los que se pueden formar todo tipo de estructuras, como las que formaríamos combinando arreglos asociativos.</p>

<h3>¿Cual es entonces la diferencia entre un objeto y un arreglo asociativo?</h3>

<p>Si el objetivo es generar estructuras de información para poder compartirlas con otros programas o mediante internet, no hay ninguna diferencia entre usar arreglos asociativos u objetos.</p>

<p>Al convertir datos de php a datos de otras tecnologías los arreglos asociativos se convierten en objetos de esas tecnologías y viceversa, al convertir datos de otras tecnologías a datos de php los datos de tipo objeto de otras tecnología se pueden convertir en arreglos asociativos de php.</p>

<h4>¿Entonces para que sirven los objetos en PHP? ó ¿Cuando debería usar dichos tipos de datos?</h4>

<p>Aunque en concepto y en su forma de transferir datos son lo mismo, un arreglo asociativo se diferencia de un objeto literal de PHP en que este ultimo cuenta con muchas mas características y funcionalidades, y a continuación veremos varias de esas características y veremos que problemas resuelve cada una.</p>


<h2>Características de la Programación Orientada a Objetos</h2>

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

<p>Otra característica interesante de la programación orientada a objetos es la opción de poder tomar código de objetos para crear definiciones nuevas que reutilicen total o parcialmente el código existente y crear con esto nuevas variaciones variaciones de objetos que cuenten con nuevas funcionalidades ó que cambien el comportamiento previamente establecido y solo respeten las interfaces.</p>

<p>A esta característica se le llama <strong>Herencia</strong> y aunque su comportamiento se puede emular en la programación sin tener que recurrir a objetos, con objetos lograr la herencia es extremadamente fácil.</p>

<h3>Modularidad</h3>

<p>La modularidad consiste en dividir tu programa en partes mas pequeñas con el fin de hacer mas claro y transparente su funcionamiento y con esto hacer más fácil el mantenimiento.</p>

<p>En PHP y en otros sistemas un módulo puede ser solo un archivo con apenas algo de código, y ese código no tendría precisamente porque ser un objeto.</p>

<p>Un modulo podría ser solo una función o un conjunto de variables o constantes, el punto es separar nuestro software en partes mas pequeñas.</p>

<p>Por su naturaleza los objetos tienden a ser modulares, y un software compuesto de multiples objetos puede ser fácilmente dividido en multiples archivos archivos con un objeto cada uno.</p>

<p>En PHP trabajar con objetos hace que la modularidad sea aún más fácil ya que al trabajar con estas estructuras podemos definir reglas simples para que el motor de PHP ensamble el software con los objetos necesarios según se van requiriendo.</p>

<h3>Composición</h3>

<p>La composición se basa en construir piezas de software juntando otras piezas mas pequeñas, básicamente sacarle todo el provecho a la modularidad</p>

<p>Podemos definir objetos como atributos de otros objetos, lo que permite crear todo tipo de estructuras.</p>

<p>Esta es otra forma de reutilizar código y es la mas recomendada, se recomienda incluso por sobre la herencia.</p>

<p>Un código modular con piezas bien definidas y construidas con código limpio da lugar a poder componer y recomponer nuevas estructuras tan complejas según los casos de uso que enfrentemos lo requieran.</p>

<h2>En resumen</h2>

<p>Los objectos permiten de forma fácil organizar y reutilizar código.</p>

<p>Permiten pasar de un montón de variables y funciones sueltas que podrían o no estar relacionados entre si a capsulas que agrupan datos y su comportamiento y que definen una interfaz que detalla la forma en la que los objectos se conectan e interactúan con otros objetos y otros módulos</p>

<p>Los objetos promueven el trabajar con abstracciones, que consiste en ocultar los detalles complejos y enfocarse solo en determinadas propiedades de las cosas.</p>

<p>Los objetos que comparten la misma interfaz pueden ser intercambiados entre si, esto facilita la modularidad y la reutilización de código</p>
