<?php
/**
 * @author Fabian Fuelling <fabian@fabfuel.de>
 * @created: 14.11.14 12:13
 */

namespace Fabfuel\Prophiler\Plugin\Phalcon\Mvc;

use Fabfuel\Prophiler\Plugin\Phalcon\PhalconPluginTest;
use Phalcon\Mvc\Dispatcher;

class DispatcherPluginTest extends PhalconPluginTest
{
    /**
     * @var DispatcherPlugin
     */
    protected $dispatcherPlugin;

    public function setUp()
    {
        parent::setUp();
        $this->dispatcherPlugin = DispatcherPlugin::getInstance($this->getProfiler());
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     */
    public function testDispatchLoop()
    {
        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $this->profiler->expects($this->once())
            ->method('start')
            ->with('Phalcon\Mvc\Dispatcher::dispatchLoop', [], 'Dispatcher')
            ->willReturn($benchmark);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark);

        $event = $this->getMockBuilder('Phalcon\Events\Event')
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->exactly(1))
            ->method('getSource')
            ->willReturn(new \Phalcon\Mvc\Dispatcher);

        $this->dispatcherPlugin->beforeDispatchLoop($event);
        $this->dispatcherPlugin->afterDispatchLoop($event);
    }

    /**
     * @covers Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Plugin\PluginAbstract
     */
    public function testExecuteRoute()
    {
        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $metadata = [
            'executed' => 'stdClass::testAction',
            'controller' => 'foobar',
            'action' => 'test',
            'params' => ['test-params' => 'foobar'],
        ];

        $dispatcher = $this->getMock('Phalcon\Mvc\Dispatcher');

        $dispatcher->expects($this->once())
            ->method('getControllerName')
            ->willReturn('foobar');

        $dispatcher->expects($this->exactly(2))
            ->method('getActionName')
            ->willReturn('test');

        $dispatcher->expects($this->once())
            ->method('getParams')
            ->willReturn(['test-params' => 'foobar']);

        $dispatcher->expects($this->once())
            ->method('getActiveController')
            ->willReturn(new \stdClass);

        $this->profiler->expects($this->once())
            ->method('start')
            ->with('Phalcon\Mvc\Dispatcher::executeRoute', $metadata, 'Dispatcher')
            ->willReturn($benchmark);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark);

        $event = $this->getMockBuilder('Phalcon\Events\Event')
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->exactly(1))
            ->method('getSource')
            ->willReturn(new Dispatcher());

        $this->dispatcherPlugin->beforeExecuteRoute($event, $dispatcher);
        $this->dispatcherPlugin->afterExecuteRoute($event);
    }
}
