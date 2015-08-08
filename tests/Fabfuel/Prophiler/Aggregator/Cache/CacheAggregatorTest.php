<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 07.08.15, 07:54
 */
namespace Fabfuel\Prophiler\Aggregator\Cache;

class CacheAggregatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CacheAggregator
     */
    protected $aggregator;

    public function setUp()
    {
        $this->aggregator = new CacheAggregator();
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\Cache\CacheAggregator::accept
     */
    public function testAccept()
    {
        $validBenchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $validBenchmark->expects($this->any())
            ->method('getComponent')
            ->willReturn('Cache');

        $validBenchmarkApc = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $validBenchmarkApc->expects($this->any())
            ->method('getComponent')
            ->willReturn('Cache APC');

        $invalidBenchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $invalidBenchmark->expects($this->any())
            ->method('getComponent')
            ->willReturn('Foobar');

        $this->assertTrue($this->aggregator->accept($validBenchmark));
        $this->assertTrue($this->aggregator->accept($validBenchmarkApc));
        $this->assertFalse($this->aggregator->accept($invalidBenchmark));
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\Cache\CacheAggregator::getCommand
     */
    public function testGetCommand()
    {
        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $benchmark->expects($this->any())
            ->method('getName')
            ->willReturn('Lorem Ipsum');

        $this->assertSame('Lorem Ipsum', $this->aggregator->getCommand($benchmark));
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\Cache\CacheAggregator::getIcon
     */
    public function testGetIcon()
    {
        $this->assertSame('<i class="fa fa-stack-exchange"></i>', $this->aggregator->getIcon());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\Cache\CacheAggregator::getTitle
     */
    public function testGetTitle()
    {
        $this->assertSame('Cache', $this->aggregator->getTitle());
    }
}
