<?php

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

$items = [
    [
        "id" => "1bccc7b7-94bb-4384-ab97-24093bb71a01",
        "parent" => null,
        "value" => "Hello world!",
        "weight" => 100,
        "type" => "h1",
        "children" => [],
    ],
    [
        "id" => "a4ce0b7a-5d1f-4a49-85f7-41cbfb0dd6fb",
        "parent" => null,
        "value" => null,
        "weight" => 100,
        "type" => "container",
        "children" => [],
    ],
    [
        "id" => "53afa943-ed66-44c6-a94b-3730877f54fe",
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
        "id" => "ec6b9ea6-d971-426c-9cd2-c76d27398b3a",
        "parent" => "a4ce0b7a-5d1f-4a49-85f7-41cbfb0dd6fb",
        "value" => null,
        "weight" => 100,
        "type" => "text",
        "children" => [],
    ],
    [
        "id" => "b5dd35c0-a18b-41b6-8af4-9ddeb0eb7f87",
        "parent" => "a4ce0b7a-5d1f-4a49-85f7-41cbfb0dd6fb",
        "value" => null,
        "weight" => 100,
        "type" => "ul",
        "children" => [],
    ],
    [
        "id" => "abc56ea7-b014-409c-b724-1be0d7191fbc",
        "parent" => "b5dd35c0-a18b-41b6-8af4-9ddeb0eb7f87",
        "value" => "lorem ipsum dolor",
        "weight" => 100,
        "type" => "item",
        "children" => [],
    ],
    [
        "id" => "db85a32e-b50e-4c72-8ce5-5b38dd702a19",
        "parent" => "b5dd35c0-a18b-41b6-8af4-9ddeb0eb7f87",
        "value" => "sit amet consectetur",
        "weight" => 100,
        "type" => "item",
        "children" => [],
    ],
    [
        "id" => "45a6ba9e-b3ef-4f74-994e-1e932c0115a0",
        "parent" => "ec6b9ea6-d971-426c-9cd2-c76d27398b3a",
        "value" => "lorem ipsum dolor",
        "weight" => 90,
        "type" => "item",
        "children" => [],
    ],
    [
        "id" => "9e433cf7-8645-452c-bab5-592b5bb33fa3",
        "parent" => "ec6b9ea6-d971-426c-9cd2-c76d27398b3a",
        "value" => "sit amet consectetur",
        "weight" => 100,
        "type" => "item",
        "children" => [],
    ],
    [
        "id" => "4206ea2d-380f-4e83-a5df-59ccd3a5c3be",
        "parent" => "ec6b9ea6-d971-426c-9cd2-c76d27398b3a",
        "value" => "https://picsum.photos/200/300",
        "weight" => 100,
        "type" => "img",
        "children" => [],
    ],
];

$nodesAll = [];
$nodesRoot = [];

foreach ($items as $k => $item) {
    $nodesAll[$item['id']] = &$items[$k];
}

foreach ($nodesAll as $k => $item) {
    if (!is_null($item['parent'])) {
        $nodesAll[$item['parent']]['children'][] = &$nodesAll[$k];
    } else {
        $nodesRoot[] = &$nodesAll[$k];
    }
}

foreach ($nodesAll as $k => $item) {

    $render = $RenderClasses[$item['type']] ?? null;

    if (!isset($render)) {
        $render = $RenderClasses['default'];
    }

    $nodesAll[$k] = new $render($item['value'], $item['children']);
}

$HTMLrender = array_reduce($nodesRoot, fn($carry, $item) => $carry . $item);

echo $HTMLrender;

// result:

/*
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
*/