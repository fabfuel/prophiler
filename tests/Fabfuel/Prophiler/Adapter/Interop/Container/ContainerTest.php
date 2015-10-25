<?php
/**
 * @author @shochdoerfer <S.Hochdoerfer@bitExpert.de>
 * @created 23.10.15, 10:59
 */
namespace Fabfuel\Prophiler\Adapter\Interop\Container;

use \Fabfuel\Prophiler\Benchmark\Benchmark;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Interop\Container\ContainerInterface
     */
    protected $container;
    /**
     * @var \Fabfuel\Prophiler\ProfilerInterface
     */
    protected $profiler;
    /**
     * @var \Fabfuel\Prophiler\Adapter\Interop\Container\Container
     */
    protected $adapter;

    /**
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        parent::setUp();

        $this->container = $this->getMock('Interop\Container\ContainerInterface');
        $this->profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');
        $this->adapter = new Container($this->container, $this->profiler);
    }

    public function testHasCallTriggersProfiler()
    {
        $this->profiler->expects($this->once())
            ->method('start')
            ->will($this->returnValue(new Benchmark('test')));
        $this->profiler->expects($this->once())
            ->method('stop')
            ->will($this->returnValue(new Benchmark('test')));

        $this->adapter->has('sample-id');
    }

    public function testGetCallTriggersProfiler()
    {
        $this->profiler->expects($this->once())
            ->method('start')
            ->will($this->returnValue(new Benchmark('test')));
        $this->profiler->expects($this->once())
            ->method('stop')
            ->will($this->returnValue(new Benchmark('test')));
        $this->container->expects($this->once())
            ->method('get')
            ->will($this->returnValue(new \stdClass()));

        $instance = $this->adapter->get('sample-id');
        $this->assertInstanceOf('\stdClass', $instance);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetCallThrowsExceptionAndStillTriggersProfiler()
    {
        $this->profiler->expects($this->once())
            ->method('start')
            ->will($this->returnValue(new Benchmark('test')));
        $this->profiler->expects($this->once())
            ->method('stop')
            ->will($this->returnValue(new Benchmark('test')));
        $this->container->expects($this->once())
            ->method('get')
            ->will($this->throwException(new \RuntimeException()));

        $instance = $this->adapter->get('sample-id');
    }
}
