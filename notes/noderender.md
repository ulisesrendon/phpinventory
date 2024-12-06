# Algoritmos y estructuras de datos para renderizar sistema de bloques HTML

<h2>De árbol de nodos HTML a tabla</h2>
<table>
    <tr>
        <th>id</th>
        <th>parent</th>
        <th>value</th>
        <th>type</th>
        <th>weight</th>
    </tr>
    <tr>
        <td>1</td>
        <td>null</td>
        <td>Hello world!</td>
        <td>h1</td>
        <td>100</td>
    </tr>
    <tr>
        <td>2</td>
        <td>null</td>
        <td>null</td>
        <td>container</td>
        <td>100</td>
    </tr>
    <tr>
        <td>3</td>
        <td>null</td>
        <td><pre>&lt;h1&gt;Hello world!&lt;/h1&gt;
&lt;div&gt;
    &lt;div class="text"&gt;
        &lt;p&gt;lorem ipsum dolor&lt;/p&gt;
        &lt;p&gt;sit amet consectetur&lt;/p&gt;
        &lt;p&gt;&lt;img src="https://picsum.photos/200/300"&gt;&lt;/p&gt;
    &lt;/div&gt; 
    &lt;ul&gt;
        &lt;li&gt;lorem ipsum dolor&lt;/li&gt;
        &lt;li&gt;sit amet consectetur&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;</pre></td>
        <td>code-plain</td>
        <td>100</td>
    </tr>
    <tr>
        <td>4</td>
        <td>2</td>
        <td>null</td>
        <td>text</td>
        <td>100</td>
    </tr>
    <tr>
        <td>5</td>
        <td>2</td>
        <td>null</td>
        <td>ul</td>
        <td>100</td>
    </tr>
    <tr>
        <td>6</td>
        <td>5</td>
        <td>lorem ipsum dolor</td>
        <td>item</td>
        <td>100</td>
    </tr>
    <tr>
        <td>7</td>
        <td>5</td>
        <td>sit amet consectetur</td>
        <td>item</td>
        <td>100</td>
    </tr>
    <tr>
        <td>8</td>
        <td>4</td>
        <td>lorem ipsum dolor</td>
        <td>item</td>
        <td>90</td>
    </tr>
    <tr>
        <td>9</td>
        <td>4</td>
        <td>sit amet consectetur</td>
        <td>item</td>
        <td>100</td>
    </tr>
    <tr>
        <td>10</td>
        <td>4</td>
        <td>https://picsum.photos/200/300</td>
        <td>img</td>
        <td>100</td>
    </tr>
</table>

<h2>Código PHP</h2>

<h3>Clase base para renderizar bloques de contenido</h3>

```php
class HyperItemsRenderDefault implements \Stringable
{
    protected mixed $value;
    protected array $children;

    public function __construct(
        mixed $value = null,
        array $children = []
    ) {
        $this->value = $value;
        $this->children = $children;
    }

    public function render(): string
    {
        return json_encode([
            'value' => $this->value,
            'children' => $this->children,
        ]);
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
```

<h3>Resto de clases derivadas</h3>

```php

class HyperItemsRenderForContainer extends HyperItemsRenderDefault
{
    public function render(): string
    {
        $content = implode('', $this->children);
        return "<div>$content</div>";
    }
}

class HyperItemsRenderForText extends HyperItemsRenderDefault
{
    public function render(): string
    {
        $content = array_reduce($this->children, fn($carry, $item) => $carry . "<p>$item</p>");

        return "<div>$content</div>";
    }
}

class HyperItemsRenderForImg extends HyperItemsRenderDefault
{
    public function render(): string
    {
        return "<img src=\"$this->value\">";
    }
}
class HyperItemsRenderForH1 extends HyperItemsRenderDefault
{
    public function render(): string
    {
        return "<h1>$this->value</h1>";
    }
}
class HyperItemsRenderForItem extends HyperItemsRenderDefault
{
    public function render(): string
    {
        return $this->value;
    }
}

class HyperItemsRenderForUl extends HyperItemsRenderDefault
{
    public function render(): string
    {
        $content = array_reduce($this->children, fn($carry, $item) => $carry . "<li>$item</li>");

        return "<ul>$content</ul>";
    }
}

class HyperItemsRenderForPlainCode extends HyperItemsRenderDefault
{
    public function render(): string
    {
        $value = htmlspecialchars($this->value);
        return "<pre><code>$value</code></pre>";
    }
}
```

<h3>Mapeo de clases y tipos de bloque de contenido</h3>

```php
$RenderClasses = [
    'default' => HyperItemsRenderDefault::class,
    'container' => HyperItemsRenderForContainer::class,
    'text' => HyperItemsRenderForText::class,
    'img' => HyperItemsRenderForImg::class,
    'h1' => HyperItemsRenderForH1::class,
    'item' => HyperItemsRenderForItem::class,
    'ul' => HyperItemsRenderForUl::class,
    'code-plain' => HyperItemsRenderForPlainCode::class,
];
```

<h3>Arreglo de prueba con datos de bloques de contenido</h3>

```php
$items = [
    [
        "id" => "1",
        "parent" => null,
        "value" => "Hello world!",
        "weight" => 100,
        "type" => "h1",
        "children" => [],
    ],
    [
        "id" => "2",
        "parent" => null,
        "value" => null,
        "weight" => 100,
        "type" => "container",
        "children" => [],
    ],
    [
        "id" => "3",
        "parent" => null,
        "value" => '<h1>Hello world!</h1>
<div>
    <div class="text">
        <p>lorem ipsum dolor</p>
        <p>sit amet consectetur</p>
        <p><img src="https://picsum.photos/200/300"></p>
    </div> 
    <ul>
        <li>lorem ipsum dolor</li>
        <li>sit amet consectetur</li>
    </ul>
</div>',
        "weight" => 100,
        "type" => "code-plain",
        "children" => [],
    ],
    [
        "id" => "4",
        "parent" => "2",
        "value" => null,
        "weight" => 100,
        "type" => "text",
        "children" => [],
    ],
    [
        "id" => "5",
        "parent" => "2",
        "value" => null,
        "weight" => 100,
        "type" => "ul",
        "children" => [],
    ],
    [
        "id" => "6",
        "parent" => "5",
        "value" => "lorem ipsum dolor",
        "weight" => 100,
        "type" => "item",
        "children" => [],
    ],
    [
        "id" => "7",
        "parent" => "5",
        "value" => "sit amet consectetur",
        "weight" => 100,
        "type" => "item",
        "children" => [],
    ],
    [
        "id" => "8",
        "parent" => "4",
        "value" => "lorem ipsum dolor",
        "weight" => 90,
        "type" => "item",
        "children" => [],
    ],
    [
        "id" => "9",
        "parent" => "4",
        "value" => "sit amet consectetur",
        "weight" => 100,
        "type" => "item",
        "children" => [],
    ],
    [
        "id" => "10",
        "parent" => "4",
        "value" => "https://picsum.photos/200/300",
        "weight" => 100,
        "type" => "img",
        "children" => [],
    ],
];
```

<h3>Algoritmo para convertir de tabla de datos a árbol de nodos</h3>

```php
$nodesMap = []; // Nodes in Map structure
$nodesTree = []; // Nodes in Tree structure

// Generate Map structure
foreach ($items as $k => $item) {
    $nodesMap[$item['id']] = &$items[$k];
}

// Nesting nodes and generate tree structure
foreach ($nodesMap as $k => $item) {
    if (!is_null($item['parent'])) {
        $nodesMap[$item['parent']]['children'][] = &$nodesMap[$k];
    } else {
        $nodesTree[] = &$nodesMap[$k];
    }
}
```

<h3>Algoritmo para asignar la lógica de renderizado y poder imprimir HTML final</h3>

```php
// Instantiate the correct Render Object for each node
foreach ($nodesMap as $k => $item) {
    $render = $RenderClasses[$item['type']] ?? null;
    if (!isset($render)) {
        $render = $RenderClasses['default'];
    }
    $nodesMap[$k] = new $render($item['value'], $item['children']);
}

$HTMLrender = array_reduce($nodesTree, fn($carry, $item) => $carry . $item); // Final HTML

echo $HTMLrender;
```

<h2>Código HTML resultante</h2>

<pre><code>&lt;h1&gt;Hello world!&lt;/h1&gt;
&lt;div&gt;
    &lt;div&gt;
        &lt;p&gt;lorem ipsum dolor&lt;/p&gt;
        &lt;p&gt;sit amet consectetur&lt;/p&gt;
        &lt;p&gt;&lt;img src=&quot;https://picsum.photos/200/300&quot; /&gt;&lt;/p&gt;
    &lt;/div&gt;
    &lt;ul&gt;
        &lt;li&gt;lorem ipsum dolor&lt;/li&gt;
        &lt;li&gt;sit amet consectetur&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;
&lt;pre&gt;&lt;code&gt;&amp;lt;h1&amp;gt;Hello world!&amp;lt;/h1&amp;gt;
&amp;lt;div&amp;gt;
    &amp;lt;div class=&quot;text&quot;&amp;gt;
        &amp;lt;p&amp;gt;lorem ipsum dolor&amp;lt;/p&amp;gt;
        &amp;lt;p&amp;gt;sit amet consectetur&amp;lt;/p&amp;gt;
        &amp;lt;p&amp;gt;&amp;lt;img src=&quot;https://picsum.photos/200/300&quot;&amp;gt;&amp;lt;/p&amp;gt;
    &amp;lt;/div&amp;gt; 
    &amp;lt;ul&amp;gt;
        &amp;lt;li&amp;gt;lorem ipsum dolor&amp;lt;/li&amp;gt;
        &amp;lt;li&amp;gt;sit amet consectetur&amp;lt;/li&amp;gt;
    &amp;lt;/ul&amp;gt;
&amp;lt;/div&amp;gt;&lt;/code&gt;&lt;/pre&gt;</code></pre>


<h1>Hello world!</h1>
<div>
    <div>
        <p>lorem ipsum dolor</p>
        <p>sit amet consectetur</p>
        <p><img src="https://picsum.photos/200/300" /></p>
    </div>
    <ul>
        <li>lorem ipsum dolor</li>
        <li>sit amet consectetur</li>
    </ul>
</div>
<pre><code>&lt;h1&gt;Hello world!&lt;/h1&gt;
&lt;div&gt;
    &lt;div class="text"&gt;
        &lt;p&gt;lorem ipsum dolor&lt;/p&gt;
        &lt;p&gt;sit amet consectetur&lt;/p&gt;
        &lt;p&gt;&lt;img src="https://picsum.photos/200/300"&gt;&lt;/p&gt;
    &lt;/div&gt; 
    &lt;ul&gt;
        &lt;li&gt;lorem ipsum dolor&lt;/li&gt;
        &lt;li&gt;sit amet consectetur&lt;/li&gt;
    &lt;/ul&gt;
&lt;/div&gt;</code></pre>