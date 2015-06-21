<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created: 19.06.15 15:32
 */

namespace Fabfuel\Prophiler\Decorator\Elasticsearch;

use Elasticsearch\Client;
use Fabfuel\Prophiler\ProfilerInterface;

class ClientDecoratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientDecorator
     */
    protected $decorator;

    /**
     * @var ProfilerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $profiler;

    /**
     * @var Client|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $client;

    public function setUp()
    {
        $this->profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');
        $this->client = $this->getMock('\Elasticsearch\Client', ['get', 'search'], [], 'ElasticMock');
        $this->decorator = new ClientDecorator($this->client, $this->profiler);
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\Elasticsearch\ClientDecorator::__construct
     * @covers Fabfuel\Prophiler\Decorator\Elasticsearch\ClientDecorator::getProfiler
     * @covers Fabfuel\Prophiler\Decorator\Elasticsearch\ClientDecorator::setProfiler
     * @covers Fabfuel\Prophiler\Decorator\Elasticsearch\ClientDecorator::getDecorated
     * @covers Fabfuel\Prophiler\Decorator\Elasticsearch\ClientDecorator::setDecorated
     */
    public function testConstruct()
    {
        $this->assertSame($this->profiler, $this->decorator->getProfiler());
        $this->assertSame($this->client, $this->decorator->getDecorated());
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\Elasticsearch\ClientDecorator::getBenchmarkName
     */
    public function testGetBenchmarkName()
    {
        $method = 'foobar';
        $expected = sprintf('%s::%s', 'ElasticMock', $method);
        $name = $this->decorator->getBenchmarkName($method);

        $this->assertSame($expected, $name);
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\Elasticsearch\ClientDecorator::getComponentName
     */
    public function testGetComponentName()
    {
        $name = $this->decorator->getComponentName();
        $this->assertSame('Elasticsearch', $name);
    }

    /**
     * @covers Fabfuel\Prophiler\Decorator\Elasticsearch\ClientDecorator::__call
     */
    public function testCall()
    {
        $payload = ['lorem' => 'ipsum'];
        $benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $this->client->expects($this->once())
            ->method('get')
            ->with($payload);

        $this->profiler->expects($this->once())
            ->method('start')
            ->with('ElasticMock::get', [$payload], 'Elasticsearch')
            ->willReturn($benchmark);

        $this->profiler->expects($this->once())
            ->method('stop')
            ->with($benchmark);

        $this->decorator->get($payload);
    }
}
