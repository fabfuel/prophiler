<?php
/**
 * @author Fabian Fuelling <fabian@fabfuel.de>
 * @created: 14.11.14 12:13
 */

namespace Fabfuel\Prophiler\Plugin\Phalcon\Mvc;

use Fabfuel\Prophiler\Profiler;
use Phalcon\DI;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Dispatcher
     */
    protected $dispatcherPlugin;

    /**
     * @var Profiler|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $profiler;

    public function setUp()
    {
        DI::setDefault(new DI\FactoryDefault());

        $this->dispatcherPlugin = new Dispatcher();

        $this->profiler = $this->getMockBuilder('Fabfuel\Prophiler\Profiler')->getMock();
        DI::getDefault()->set('profiler', $this->profiler, true);
    }

    public function testDispathLoop()
    {
        $token = 'token';

        $this->profiler->expects($this->once())
            ->method('start')
            ->with('Phalcon\Mvc\Dispatcher::dispatchLoop', [], 'Dispatcher')
            ->willReturn($token);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($token);

        $event = $this->getMockBuilder('Phalcon\Events\Event')
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->exactly(1))
            ->method('getSource')
            ->willReturn(new \Phalcon\Mvc\Dispatcher);

        $this->dispatcherPlugin->beforeDispatchLoop($event);
        $this->dispatcherPlugin->afterDispatchLoop($event);
    }

    public function testExecuteRoute()
    {
        $token = 'token';
        $metadata = [
            'module' => 'test-module',
            'controller' => 'test-controller',
            'action' => 'test-action',
            'params' => ['test-params' => 'foobar'],
            'class' => 'stdClass',
        ];

        $router = $this->getMockBuilder('Phalcon\Mvc\Router')->getMock();
        $dispatcher = $this->getMockBuilder('Phalcon\Mvc\Dispatcher')->getMock();

        DI::getDefault()->set('router', $router, true);
        DI::getDefault()->set('dispatcher', $dispatcher, true);

        $router->expects($this->once())
            ->method('getModuleName')
            ->willReturn('test-module');

        $router->expects($this->once())
            ->method('getControllerName')
            ->willReturn('test-controller');

        $router->expects($this->once())
            ->method('getActionName')
            ->willReturn('test-action');

        $router->expects($this->once())
            ->method('getParams')
            ->willReturn(['test-params' => 'foobar']);

        $dispatcher->expects($this->once())
            ->method('getActiveController')
            ->willReturn(new \stdClass);


        $this->profiler->expects($this->once())
            ->method('start')
            ->with('Phalcon\Mvc\Dispatcher::executeRoute', $metadata, 'Dispatcher')
            ->willReturn($token);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($token);

        $event = $this->getMockBuilder('Phalcon\Events\Event')
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->exactly(1))
            ->method('getSource')
            ->willReturn(new \Phalcon\Mvc\Dispatcher);

        $this->dispatcherPlugin->beforeExecuteRoute($event);
        $this->dispatcherPlugin->afterExecuteRoute($event);
    }
}
