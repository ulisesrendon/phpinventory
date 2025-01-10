<?php
use PHPUnit\Framework\TestCase;
use Stradow\Framework\Render\HyperRender;
use Stradow\Framework\Render\Interface\NestableInterface;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\PrettifierInterface;

final class HyperRenderTest extends TestCase
{
    private $mockPrettifier;
    private $mockNode1;
    private $mockNode2;
    private $mockNode3;

    protected function setUp(): void
    {
        $this->mockPrettifier = Mockery::mock(PrettifierInterface::class);
        $this->mockNode1 = Mockery::mock(NestableInterface::class, BlockStateInterface::class);
        $this->mockNode2 = Mockery::mock(NestableInterface::class, BlockStateInterface::class);
        $this->mockNode3 = Mockery::mock(NestableInterface::class, BlockStateInterface::class);

        $this->mockNode1->shouldReceive('getId')->andReturn('node1');
        $this->mockNode2->shouldReceive('getId')->andReturn('node2');
        $this->mockNode3->shouldReceive('getId')->andReturn('node3');

        $this->mockNode1->shouldReceive('getParent')->andReturnNull();
        $this->mockNode2->shouldReceive('getParent')->andReturn('node1');
        $this->mockNode3->shouldReceive('getParent')->andReturn('node1');

        // Add expectations for addChild()
        $this->mockNode1->shouldReceive('addChild')->with($this->mockNode2);
        $this->mockNode2->shouldReceive('addChild')->with($this->mockNode3);

    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testConstructor(): void
    {
        $hyperRender = new HyperRender([$this->mockNode1, $this->mockNode2]);
        $this->assertCount(2, $hyperRender);
    }

    public function testAddNode(): void
    {
        $hyperRender = new HyperRender();
        $hyperRender->addNode($this->mockNode1);
        $this->assertCount(1, $hyperRender);
    }

    public function testRender(): void
    {
        $this->mockNode1->shouldReceive('getLayoutNodes')->andReturnNull();
        $this->mockNode1->shouldReceive('getRender')->andReturn('Node1Render');
        $this->mockNode2->shouldReceive('getLayoutNodes')->andReturnNull();
        $this->mockNode2->shouldReceive('getRender')->andReturn('Node2Render');

        $hyperRender = new HyperRender([$this->mockNode1, $this->mockNode2]);

        $output = $hyperRender->render();
        $this->assertEquals('Node1Render', $output);
    }

    public function testGetMapSchema(): void
    {
        $this->mockNode1->shouldReceive('getValue')->andReturn('Node1Value');
        $this->mockNode1->shouldReceive('getProperties')->andReturn(['property1' => 'value1']);
        $this->mockNode1->shouldReceive('getType')->andReturn('nodeType1');

        $this->mockNode2->shouldReceive('getValue')->andReturn('Node2Value');
        $this->mockNode2->shouldReceive('getProperties')->andReturn(['property2' => 'value2']);
        $this->mockNode2->shouldReceive('getType')->andReturn('nodeType2');

        $hyperRender = new HyperRender([$this->mockNode1, $this->mockNode2]);

        $expectedSchema = [
            'node1' => [
                'value' => 'Node1Value',
                'parent' => null,
                'properties' => ['property1' => 'value1'],
                'render' => null,
            ],
            'node2' => [
                'value' => 'Node2Value',
                'parent' => 'node1',
                'properties' => ['property2' => 'value2'],
                'render' => null,
            ],
        ];

        $this->assertEquals($expectedSchema, $hyperRender->getMapSchema());

        // Test with renderConfig
        $renderConfig = ['nodeType1' => 'CustomRenderer1', 'nodeType2' => 'CustomRenderer2'];
        $expectedSchemaWithConfig = [
            'node1' => [
                'value' => 'Node1Value',
                'parent' => null,
                'properties' => ['property1' => 'value1'],
                'render' => 'CustomRenderer1',
            ],
            'node2' => [
                'value' => 'Node2Value',
                'parent' => 'node1',
                'properties' => ['property2' => 'value2'],
                'render' => 'CustomRenderer2',
            ],
        ];
        $this->assertEquals($expectedSchemaWithConfig, $hyperRender->getMapSchema($renderConfig));
    }

    public function testGetTreeSchema(): void
    {
        $this->mockNode1->shouldReceive('getValue')->andReturn('Node1Value');
        $this->mockNode1->shouldReceive('getParent')->andReturnNull();
        $this->mockNode1->shouldReceive('getProperties')->andReturn(['property1' => 'value1']);
        $this->mockNode1->shouldReceive('getType')->andReturn('nodeType1');

        $this->mockNode2->shouldReceive('getValue')->andReturn('Node2Value');
        $this->mockNode2->shouldReceive('getParent')->andReturn('node1');
        $this->mockNode2->shouldReceive('getProperties')->andReturn(['property2' => 'value2']);
        $this->mockNode2->shouldReceive('getType')->andReturn('nodeType2');

        $hyperRender = new HyperRender([$this->mockNode1, $this->mockNode2]);

        $expectedTree = [
            'node1' => [
                'value' => 'Node1Value',
                'parent' => null,
                'properties' => ['property1' => 'value1'],
                'render' => null,
                'children' => [
                    [
                        'value' => 'Node2Value',
                        'parent' => 'node1',
                        'properties' => ['property2' => 'value2'],
                        'render' => null,
                        'children' => [],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expectedTree, $hyperRender->getTreeSchema());
    }

    public function testCount(): void
    {
        $hyperRender = new HyperRender([$this->mockNode1, $this->mockNode2]);
        $this->assertEquals(2, $hyperRender->count());
    }

    public function testGetIterator(): void
    {
        $hyperRender = new HyperRender([$this->mockNode1, $this->mockNode2]);
        $iterator = $hyperRender->getIterator();

        $this->assertInstanceOf(Traversable::class, $iterator);
        $this->assertEquals($this->mockNode1, $iterator->current());
    }
}