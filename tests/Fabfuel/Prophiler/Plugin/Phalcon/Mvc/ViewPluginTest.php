<?php
/**
 * @author Fabian Fuelling <fabian@fabfuel.de>
 * @created: 14.11.14 12:13
 */

namespace Fabfuel\Prophiler\Plugin\Phalcon\Mvc;

use Fabfuel\Prophiler\Plugin\Phalcon\PhalconPluginTest;

class ViewPluginTest extends PhalconPluginTest
{
    /**
     * @var ViewPlugin
     */
    protected $viewPlugin;

    public function setUp()
    {
        parent::setUp();
        $this->viewPlugin = ViewPlugin::getInstance($this->getProfiler());
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::beforeRenderView
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::afterRenderView
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::getRenderLevel
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::setBenchmark
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::getBenchmark
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testRenderView()
    {
        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $view = $this->getMock('Phalcon\Mvc\View');

        $event = $this->getMockBuilder('Phalcon\Events\Event')
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->exactly(1))
            ->method('getSource')
            ->willReturn($view);

        $view->expects($this->once())
            ->method('getCurrentRenderLevel')
            ->willReturn(1);

        $view->expects($this->exactly(5))
            ->method('getActiveRenderPath')
            ->willReturn('main');

        $metadata = [
            'view' => 'main',
            'level' => 'action',
        ];

        $this->profiler->expects($this->once())
            ->method('start')
            ->with(get_class($view) . '::render: main', $metadata, 'View')
            ->willReturn($benchmark);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark);

        $this->viewPlugin->beforeRenderView($event, $view);
        $this->viewPlugin->afterRenderView($event, $view);
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::afterRender
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testAfterRenderWithouPendingBenchmarks()
    {
        $view = $this->getMock('Phalcon\Mvc\View');

        $event = $this->getMockBuilder('Phalcon\Events\Event')
            ->disableOriginalConstructor()
            ->getMock();

        $this->getProfiler()
            ->expects($this->never())
            ->method('stop');

        $this->viewPlugin->afterRender($event, $view);
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::afterRender
     * @uses Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testAfterRender()
    {
        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $event = $this->getMockBuilder('Phalcon\Events\Event')
            ->disableOriginalConstructor()
            ->getMock();

        $view = $this->getMock('Phalcon\Mvc\View');

        $this->viewPlugin->setBenchmark($view, $benchmark);

        $this->getProfiler()
            ->expects($this->once())
            ->method('stop')
            ->with($benchmark);

        $this->viewPlugin->afterRender($event, $view);
    }

    /**
     * @param $renderLevelInt
     * @param $renderLevelString
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::getRenderLevel
     * @covers Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Profiler
     * @dataProvider getRenderLevels
     */
    public function testGetRenderLevel($renderLevelInt, $renderLevelString)
    {
        $this->assertSame($renderLevelString, $this->viewPlugin->getRenderLevel($renderLevelInt));
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::getIdentifier
     * @covers Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testGetIdentifier()
    {
        $view = $this->getMock('Phalcon\Mvc\View');

        $view->expects($this->any())
            ->method('getActiveRenderPath')
            ->willReturn('test');

        $this->assertSame(md5('test'), $this->viewPlugin->getIdentifier($view));
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::getBenchmark
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin::setBenchmark
     * @covers Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testGetAndSetBenchmark()
    {
        $view = $this->getMockBuilder('Phalcon\Mvc\View')
            ->disableOriginalConstructor()
            ->getMock();

        $view->expects($this->any())
            ->method('getActiveRenderPath')
            ->willReturn('test');

        $benchmark1 = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $benchmark2 = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $this->viewPlugin->setBenchmark($view, $benchmark1);
        $this->viewPlugin->setBenchmark($view, $benchmark2);

        $this->assertSame($benchmark1, $this->viewPlugin->getBenchmark($view));
        $this->assertSame($benchmark2, $this->viewPlugin->getBenchmark($view));
        $this->assertNull($this->viewPlugin->getBenchmark($view));
    }

    /**
     * @return array
     */
    public function getRenderLevels()
    {
        if(!extension_loaded('phalcon')) {
            return [
                ['foobar', ''],
                ['lorem', ''],
                ['', ''],
            ];
        }

        return [
            [\Phalcon\Mvc\View::LEVEL_ACTION_VIEW, 'action'],
            [\Phalcon\Mvc\View::LEVEL_AFTER_TEMPLATE, 'afterTemplate'],
            [\Phalcon\Mvc\View::LEVEL_BEFORE_TEMPLATE, 'beforeTemplate'],
            [\Phalcon\Mvc\View::LEVEL_LAYOUT, 'controller'],
            [\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT, 'main'],
            ['foobar', ''],
            ['lorem', ''],
            ['', ''],
        ];
    }
}
