<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created: 19.06.15 15:50
 */

namespace Fabfuel\Prophiler\Decorator\Phalcon\Cache;

use Fabfuel\Prophiler\ProfilerInterface;
use Phalcon\Cache\BackendInterface;

class BackendDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BackendDecorator
     */
    protected $decorator;

    /**
     * @var ProfilerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $profiler;

    /**
     * @var BackendInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $backend;

    public function setUp()
    {
        $this->profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');
        $this->backend = $this->getMock('\Phalcon\Cache\BackendInterface', [], [], 'CacheMock');
        $this->decorator = new BackendDecorator($this->backend, $this->profiler);
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\Phalcon\Cache\BackendDecorator::__construct
     * @covers Fabfuel\Prophiler\Decorator\Phalcon\Cache\BackendDecorator::getProfiler
     * @covers Fabfuel\Prophiler\Decorator\Phalcon\Cache\BackendDecorator::setProfiler
     * @covers Fabfuel\Prophiler\Decorator\Phalcon\Cache\BackendDecorator::getBackend
     * @covers Fabfuel\Prophiler\Decorator\Phalcon\Cache\BackendDecorator::setBackend
     */
    public function testConstruct()
    {
        $this->assertSame($this->profiler, $this->decorator->getProfiler());
        $this->assertSame($this->backend, $this->decorator->getBackend());
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\Phalcon\Cache\BackendDecorator::getBenchmarkName
     */
    public function testGetBenchmarkName()
    {
        $method = 'foobar';
        $expected = sprintf('%s::%s', 'CacheMock', $method);
        $name = $this->decorator->getBenchmarkName($method);

        $this->assertSame($expected, $name);
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\Phalcon\Cache\BackendDecorator::getComponentName
     */
    public function testGetComponentName()
    {
        $name = $this->decorator->getComponentName();
        $this->assertSame('Cache CacheMock', $name);
    }


    /**
     * @covers Fabfuel\Prophiler\Decorator\Phalcon\Cache\BackendDecorator::__call
     */
    public function testCall()
    {
        $key = 'lorem';
        $lifetime = 123;

        $benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $this->backend->expects($this->once())
            ->method('get')
            ->with($key, $lifetime);

        $this->profiler->expects($this->once())
            ->method('start')
            ->with('CacheMock::get', [$key, $lifetime], 'Cache CacheMock')
            ->willReturn($benchmark);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark);

        $this->decorator->get($key, $lifetime);
    }

    /**
     * @param string $method
     * @param array $params
     * @covers Fabfuel\Prophiler\Decorator\Phalcon\Cache\BackendDecorator
     * @dataProvider gatewayMethods
     */
    public function testCallGatewayMethods($method, array $params)
    {
        $benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $this->backend->expects($this->once())
            ->method($method)
            ->withAsArray($params);

        $this->profiler->expects($this->once())
            ->method('start')
            ->with('CacheMock::' . $method, $params, 'Cache CacheMock')
            ->willReturn($benchmark);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark);

        call_user_func_array([$this->decorator, $method], $params);
    }

    /**
     * Data provider for testing gateway methods. Returns an array of:
     *  - method name
     *  - method arguments
     *
     * @return array
     */
    public function gatewayMethods()
    {
        return [
            ['start', ['key', 123]],
            ['stop', [true]],
            ['getFrontend', []],
            ['getOptions', []],
            ['isFresh', []],
            ['isStarted', []],
            ['setLastKey', ['lastkey']],
            ['getLastKey', []],
            ['get', ['key', 123]],
            ['save', ['key', 'content', 123, true]],
            ['delete', ['key']],
            ['queryKeys', ['prefix']],
            ['exists', ['key', 123]],
            ['flush', []],
        ];
    }
}
