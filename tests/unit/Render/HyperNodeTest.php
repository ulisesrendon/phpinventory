<?php

use PHPUnit\Framework\TestCase;
use Stradow\Framework\Render\HyperNode;
use Stradow\Framework\Render\HyperRender;
use PHPUnit\Framework\MockObject\MockObject;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\RendereableInterface;

final class HyperNodeTest extends TestCase
{
    private RendereableInterface&MockObject $mockRenderEngine;
    private GlobalStateInterface&MockObject $mockGlobalState;
    private ?HyperRender $mockLayoutNodes = null;

    protected function setUp(): void
    {
        $this->mockRenderEngine = $this->createMock(RendereableInterface::class);
        $this->mockGlobalState = $this->createMock(GlobalStateInterface::class);
    }

    public function testConstructor(): void
    {
        $id = 'test-id';
        $value = 'test-value';
        $properties = ['property1' => 'value1'];
        $type = 'test-type';
        $parent = 'test-parent';

        $node = new HyperNode(
            $id,
            $value,
            $properties,
            $type,
            $parent,
            $this->mockRenderEngine,
            $this->mockGlobalState,
            $this->mockLayoutNodes
        );

        $this->assertSame($id, $node->getId());
        $this->assertSame($value, $node->getValue());
        $this->assertEquals([
            'property1' => 'value1',
            'id' => $id,
            'type' => $type,
        ], $node->getProperties());
        $this->assertSame($type, $node->getType());
        $this->assertSame($parent, $node->getParent());
        $this->assertFalse($node->isTemplated());

        $properties = ['property1' => 'value1', 'template' => true];
        $node = new HyperNode(
            $id,
            $value,
            $properties,
            $type,
            $parent,
            $this->mockRenderEngine,
            $this->mockGlobalState,
            $this->mockLayoutNodes
        );
        $this->assertTrue($node->isTemplated());
    }

    public function testSettersAndGetters(): void
    {
        $node = new HyperNode(
            'test-id',
            'test-value',
            [],
            'test-type',
            null,
            $this->mockRenderEngine,
            $this->mockGlobalState,
            $this->mockLayoutNodes
        );

        $newValue = 'new-value';
        $node->setValue($newValue);
        $this->assertSame($newValue, $node->getValue());

        $newChildren = [new stdClass(), new stdClass()];
        $node->setChildren($newChildren);
        $this->assertSame($newChildren, $node->getChildren());

        $newParent = 'new-parent';
        $node->setParent($newParent);
        $this->assertSame($newParent, $node->getParent());

        $newProperties = ['new-property' => 'new-value'];
        $node->setProperties($newProperties);
        $this->assertEquals($newProperties, $node->getProperties());

        $node->setProperty('another-property', 'another-value');
        $this->assertEquals(
            ['new-property' => 'new-value', 'another-property' => 'another-value'],
            $node->getProperties()
        );

        $this->assertSame('new-value', $node->getProperty('new-property'));
        $this->assertNull($node->getProperty('non-existent-property'));

        $node->unsetProperty('new-property');
        $this->assertNull($node->getProperty('new-property'));
    }

    public function testAddChild(): void
    {
        $node = new HyperNode(
            'test-id',
            'test-value',
            [],
            'test-type',
            null,
            $this->mockRenderEngine,
            $this->mockGlobalState,
            $this->mockLayoutNodes
        );

        $child1 = new stdClass();
        $child2 = new stdClass();

        $node->addChild($child1);
        $node->addChild($child2);

        $this->assertEquals([$child1, $child2], $node->getChildren());
    }

    public function testGetRender(): void
    {
        $node = new HyperNode(
            'test-id',
            'test-value',
            [],
            'test-type',
            null,
            $this->mockRenderEngine,
            $this->mockGlobalState,
            $this->mockLayoutNodes
        );

        $this->mockRenderEngine->expects($this->once())
            ->method('render')
            ->with($node, $this->mockGlobalState)
            ->willReturn('rendered-output');

        $this->assertEquals('rendered-output', $node->getRender());
    }

    public function testToString(): void
    {
        $node = new HyperNode(
            'test-id',
            'test-value',
            [],
            'test-type',
            null,
            $this->mockRenderEngine,
            $this->mockGlobalState,
            $this->mockLayoutNodes
        );

        $this->mockRenderEngine->expects($this->once())
            ->method('render')
            ->with($node, $this->mockGlobalState)
            ->willReturn('rendered-output');

        $this->assertEquals('rendered-output', (string) $node);
    }

    public function testSetAttributes(): void
    {
        $node = new HyperNode(
            'test-id',
            'test-value',
            ['attributes' => ['class' => 'class1 class2']],
            'test-type',
            null,
            $this->mockRenderEngine,
            $this->mockGlobalState,
            $this->mockLayoutNodes
        );

        $this->assertEquals(['class' => 'class1 class2'], $node->getAttributes());

        $node = new HyperNode(
            'test-id',
            'test-value',
            ['classList' => ['class3', 'class4']],
            'test-type',
            null,
            $this->mockRenderEngine,
            $this->mockGlobalState,
            $this->mockLayoutNodes
        );

        $this->assertEquals(['class' => 'class3 class4'], $node->getAttributes());

        $node = new HyperNode(
            'test-id',
            'test-value',
            [
                'attributes' => ['class' => 'class1 class2'],
                'classList' => ['class3', 'class4'],
            ],
            'test-type',
            null,
            $this->mockRenderEngine,
            $this->mockGlobalState,
            $this->mockLayoutNodes
        );

        $this->assertEquals(['class' => 'class1 class2 class3 class4'], $node->getAttributes());
    }

    public function testGetLayoutNodes(): void
    {
        $node = new HyperNode(
            'test-id',
            'test-value',
            [],
            'test-type',
            null,
            $this->mockRenderEngine,
            $this->mockGlobalState,
            $this->mockLayoutNodes
        );

        $this->assertSame($this->mockLayoutNodes, $node->getLayoutNodes());
    }
}