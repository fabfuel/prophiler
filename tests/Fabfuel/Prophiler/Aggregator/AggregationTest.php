<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 07.08.15, 08:03
 */
namespace Fabfuel\Prophiler\Aggregator;

class AggregationTest extends \PHPUnit_Framework_TestCase
{
    const COMMAND = 'Lorem Ipsum';

    /**
     * @var Aggregation
     */
    protected $aggregation;

    public function setUp()
    {
        $this->aggregation = new Aggregation(self::COMMAND);
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\Aggregation::__construct
     * @covers Fabfuel\Prophiler\Aggregator\Aggregation::getCommand
     */
    public function testGetCommand()
    {
        $this->assertSame(self::COMMAND, $this->aggregation->getCommand());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\Aggregation::aggregate
     * @covers Fabfuel\Prophiler\Aggregator\Aggregation::getTotalDuration
     * @covers Fabfuel\Prophiler\Aggregator\Aggregation::getTotalExecutions
     * @covers Fabfuel\Prophiler\Aggregator\Aggregation::getAvgDuration
     * @covers Fabfuel\Prophiler\Aggregator\Aggregation::getMinDuration
     * @covers Fabfuel\Prophiler\Aggregator\Aggregation::getMaxDuration
     * @covers Fabfuel\Prophiler\Aggregator\Aggregation::getBenchmarks
     */
    public function testAggregate()
    {
        $benchmark100 = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $benchmark100->expects($this->any())
            ->method('getDuration')
            ->willReturn('100');

        $benchmark200 = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $benchmark200->expects($this->any())
            ->method('getDuration')
            ->willReturn('200');

        $benchmark300 = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $benchmark300->expects($this->any())
            ->method('getDuration')
            ->willReturn('300');

        $this->assertCount(0, $this->aggregation->getBenchmarks());
        $this->assertSame(0, $this->aggregation->getTotalExecutions());
        $this->assertSame(0.0, $this->aggregation->getTotalDuration());
        $this->assertSame(0.0, $this->aggregation->getAvgDuration());
        $this->assertSame(0.0, $this->aggregation->getMinDuration());
        $this->assertSame(0.0, $this->aggregation->getMaxDuration());

        // + 100 ms benchmark
        $this->aggregation->aggregate($benchmark100);
        $this->assertCount(1, $this->aggregation->getBenchmarks());
        $this->assertSame(1, $this->aggregation->getTotalExecutions());
        $this->assertSame(100.0, $this->aggregation->getTotalDuration());
        $this->assertSame(100.0, $this->aggregation->getAvgDuration());
        $this->assertSame(100.0, $this->aggregation->getMinDuration());
        $this->assertSame(100.0, $this->aggregation->getMaxDuration());

        // + 200 ms benchmark
        $this->aggregation->aggregate($benchmark200);
        $this->assertCount(2, $this->aggregation->getBenchmarks());
        $this->assertSame(2, $this->aggregation->getTotalExecutions());
        $this->assertSame(300.0, $this->aggregation->getTotalDuration());
        $this->assertSame(150.0, $this->aggregation->getAvgDuration());
        $this->assertSame(100.0, $this->aggregation->getMinDuration());
        $this->assertSame(200.0, $this->aggregation->getMaxDuration());

        // + 300 ms benchmark
        $this->aggregation->aggregate($benchmark300);
        $this->assertCount(3, $this->aggregation->getBenchmarks());
        $this->assertSame(3, $this->aggregation->getTotalExecutions());
        $this->assertSame(600.0, $this->aggregation->getTotalDuration());
        $this->assertSame(200.0, $this->aggregation->getAvgDuration());
        $this->assertSame(100.0, $this->aggregation->getMinDuration());
        $this->assertSame(300.0, $this->aggregation->getMaxDuration());
    }
}
