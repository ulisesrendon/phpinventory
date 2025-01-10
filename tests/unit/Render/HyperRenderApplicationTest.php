<?php

namespace Stradow\Framework\Render;

use PHPUnit\Framework\TestCase;
use Stradow\Framework\Render\Data\GlobalState;
use Stradow\Framework\Render\Interface\BlockStateInterface;
use Stradow\Framework\Render\Interface\GlobalStateInterface;
use Stradow\Framework\Render\Interface\NestableInterface;
use Stradow\Framework\Render\Interface\RepoInterface;
use Mockery as m;

final class HyperRenderApplicationTest extends TestCase
{
    private $mockRepo;
    private $mockContent;

    private $mockNode1;
    private $mockNode2;
    private $mockNode3;
    private $config;
    private $renderConfig;

    protected function setUp(): void
    {
        $this->mockRepo = m::mock(RepoInterface::class);
        $this->mockContent = m::mock(\stdClass::class);

        $this->mockNode1 = m::mock(NestableInterface::class, BlockStateInterface::class);
        $this->mockNode2 = m::mock(NestableInterface::class, BlockStateInterface::class);
        $this->mockNode3 = m::mock(NestableInterface::class, BlockStateInterface::class);

        $this->mockNode1->shouldReceive('getId')->andReturn('node1');
        $this->mockNode2->shouldReceive('getId')->andReturn('node2');
        $this->mockNode3->shouldReceive('getId')->andReturn('node3');

        $this->mockNode1->shouldReceive('getParent')->andReturnNull();
        $this->mockNode2->shouldReceive('getParent')->andReturn('node1');
        $this->mockNode3->shouldReceive('getParent')->andReturn('node1');

        $this->mockNode1->shouldReceive('getContent')->andReturn('content1');
        $this->mockNode2->shouldReceive('getContent')->andReturn('content1');
        $this->mockNode3->shouldReceive('getContent')->andReturn('content2');

        $this->mockNode1->shouldReceive('getLayout')->andReturn('layout1');
        $this->mockNode2->shouldReceive('getLayout')->andReturn('layout2');
        $this->mockNode3->shouldReceive('getLayout')->andReturnNull();

        $this->mockNode1->shouldReceive('getType')->andReturn('type1');
        $this->mockNode2->shouldReceive('getType')->andReturn('type2');
        $this->mockNode3->shouldReceive('getType')->andReturn('type3');

        $this->mockNode1->shouldReceive('getWeight')->andReturn(1);
        $this->mockNode2->shouldReceive('getWeight')->andReturn(2);
        $this->mockNode3->shouldReceive('getWeight')->andReturn(3);

        $this->mockNode1->shouldReceive('getProperties')->andReturn(['property1' => 'value1']);
        $this->mockNode2->shouldReceive('getProperties')->andReturn(['property2' => 'value2']);
        $this->mockNode3->shouldReceive('getProperties')->andReturn(['property3' => 'value3']);

        $this->mockNode1->shouldReceive('getValue')->andReturn('Node1Value');
        $this->mockNode2->shouldReceive('getValue')->andReturn('Node2Value');
        $this->mockNode3->shouldReceive('getValue')->andReturn('Node3Value');

        $this->mockContent->id = 'contentId';
        $this->mockContent->path = '/path/to/content';
        $this->mockContent->title = 'Content Title';
        $this->mockContent->properties = (object)['layoutContainer' => 'root', 'layout' => 'mainLayout'];
        $this->mockContent->active = true;
        $this->mockContent->type = 'page';

        $this->config = ['some' => 'config'];
        $this->renderConfig = ['type1' => 'Renderer1', 'type2' => 'Renderer2', 'default' => 'DefaultRenderer'];
    }

    protected function tearDown(): void
    {
        m::close();
    }

    // public function testConstructor(): void
    // {
    //     $this->mockRepo->shouldReceive('getContent')->with('contentId')->andReturn($this->mockContent);
    //     $this->mockRepo->shouldReceive('getContentNodes')->with('contentId')->andReturn([$this->mockNode1, $this->mockNode2]);

    //     $app = new HyperRenderApplication('contentId', $this->mockRepo, $this->config, $this->renderConfig);

    //     $this->assertSame($this->mockContent, $app->getContent());
    // }

    // public function testConstructorWithExistingContent(): void
    // {
    //     $this->mockRepo->shouldReceive('getContent')->with('contentId')->never();

    //     $app = new HyperRenderApplication('contentId', $this->mockRepo, $this->config, $this->renderConfig);

    //     $this->assertInstanceOf(HyperRenderApplication::class, $app);
    //     $this->assertSame($this->mockContent, $app->getContent());
    // }

    // public function testConstructorWithContentNotFound(): void
    // {
    //     $this->mockRepo->shouldReceive('getContent')->with('contentId')->andReturnNull();

    //     $this->expectException(\DomainException::class);
    //     $this->expectExceptionMessage('Content not found (contentId)');

    //     new HyperRenderApplication('contentId', $this->mockRepo, $this->config, $this->renderConfig);
    // }

    // public function testGetHyperRender(): void
    // {
    //     $this->mockRepo->shouldReceive('getContent')->with('contentId')->andReturn($this->mockContent);
    //     $this->mockRepo->shouldReceive('getContentNodes')->with('contentId')->andReturn([$this->mockNode1, $this->mockNode2]);

    //     $app = new HyperRenderApplication('contentId', $this->mockRepo, $this->config, $this->renderConfig);
    //     $HyperRender = $app->getHyperRender();
    //     $this->assertSame('contentId', $HyperRender->render());
    // }



    // public function testPrepareContentNodes(): void
    // {
    //     $this->mockRepo->shouldReceive('getContent')->with('contentId')->andReturn($this->mockContent);
    //     $this->mockRepo->shouldReceive('getContentNodes')->with('contentId')->andReturn([$this->mockNode1, $this->mockNode2]);
    //     $this->mockRepo->shouldReceive('getContentNodes')->with('mainLayout')->andReturn([$this->mockNode3]);

    //     $app = new HyperRenderApplication('contentId', $this->mockRepo, $this->config, $this->renderConfig, null, $this->mockHyperRender);

    //     // Assert that HyperRender::addNode() was called with expected arguments
    //     $this->mockHyperRender->shouldHaveReceived('addNode')->with(m::type(NestableInterface::class, BlockStateInterface::class))->twice();

    //     // Assert that prepareLayoutNodes() was called
    //     $this->mockNode1->shouldHaveReceived('getLayoutNodes')->once();
    // }
}