<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 07.08.15 22:05
 */

namespace Fabfuel\Prophiler\Aggregator;


use Fabfuel\Prophiler\Adapter\Psr\Log\Logger;

class AbstractAggregatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TestableAbstractAggregator|\PHPUnit_Framework_MockObject_MockObject
     */
    private $aggregator;

    protected function setUp()
    {
        $this->aggregator = $this->getMockForAbstractClass('Fabfuel\Prophiler\Aggregator\TestableAbstractAggregator');

        $this->aggregator
            ->expects($this->any())
            ->method('accept')
            ->willReturn(true);
    }

    /**
     *
     */
    public function testAggregateIfNotAccepted()
    {
        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $this->aggregator = $this->getMockForAbstractClass('Fabfuel\Prophiler\Aggregator\AbstractAggregator');

        $this->aggregator
            ->expects($this->any())
            ->method('accept')
            ->willReturn(false);

        $this->assertFalse($this->aggregator->aggregate($benchmark));
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::aggregate
     */
    public function testAggregate()
    {
        $command = 'foobar';
        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $total = $this->getMock('\Fabfuel\Prophiler\Aggregator\AggregationInterface');
        $aggregation = $this->getMock('\Fabfuel\Prophiler\Aggregator\AggregationInterface');

        $this->aggregator->expects($this->any())
            ->method('getCommand')
            ->willReturn($command);

        $total->expects($this->once())
            ->method('aggregate')
            ->with($benchmark);

        $aggregation->expects($this->once())
            ->method('aggregate')
            ->with($benchmark);

        $this->aggregator->setTotal($total);
        $this->aggregator->setAggregations($command, $aggregation);

        $this->assertTrue($this->aggregator->aggregate($benchmark));
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getAggregations
     */
    public function testGetAggregations()
    {
        $this->assertCount(0, $this->aggregator->getAggregations());

        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->assertCount(1, $this->aggregator->getAggregations());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::count
     */
    public function testCount()
    {
        $this->assertSame(0, $this->aggregator->count());

        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->assertSame(1, $this->aggregator->count());

        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->assertSame(2, $this->aggregator->count());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getTotal
     */
    public function testGetTotalAggregation()
    {
        $total = $this->aggregator->getTotal();

        $this->assertInstanceOf('\Fabfuel\Prophiler\Aggregator\Aggregation', $total);
        $this->assertSame($total, $this->aggregator->getTotal());
        $this->assertSame($total, $this->aggregator->getTotal());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getAggregation
     */
    public function testGetAggregation()
    {
        $foobarAggregation = $this->aggregator->getAggregation('foobar');

        $this->assertInstanceOf('\Fabfuel\Prophiler\Aggregator\Aggregation', $foobarAggregation);
        $this->assertSame($foobarAggregation, $this->aggregator->getAggregation('foobar'));

        $loremIpsumAggregation = $this->aggregator->getAggregation('Lorem-Ipsum');

        $this->assertInstanceOf('\Fabfuel\Prophiler\Aggregator\Aggregation', $loremIpsumAggregation);
        $this->assertSame($loremIpsumAggregation, $this->aggregator->getAggregation('Lorem-Ipsum'));

        $this->assertNotSame($foobarAggregation, $loremIpsumAggregation);
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::isWarning
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getSeverity
     */
    public function testIsWarningByCount()
    {
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));

        $this->assertFalse($this->aggregator->isWarning());

        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));

        $this->assertTrue($this->aggregator->isWarning());
        $this->assertSame(Logger::SEVERITY_WARNING, $this->aggregator->getSeverity());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::isWarning
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getSeverity
     */
    public function testIsWarningByDuration()
    {
        $benchmarkFast = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $benchmarkFast->expects($this->any())
            ->method('getDuration')
            ->willReturn(5);

        $benchmarkSlow = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $benchmarkSlow->expects($this->any())
            ->method('getDuration')
            ->willReturn(15);

        $this->aggregator->aggregate($benchmarkFast);
        $this->assertFalse($this->aggregator->isWarning());

        $this->aggregator->aggregate($benchmarkSlow);
        $this->assertTrue($this->aggregator->isWarning());

        $this->assertSame(Logger::SEVERITY_WARNING, $this->aggregator->getSeverity());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::isCritical
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getSeverity
     */
    public function testIsCriticalByDuration()
    {
        $benchmarkFast = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $benchmarkFast->expects($this->any())
            ->method('getDuration')
            ->willReturn(15);

        $benchmarkSlow = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $benchmarkSlow->expects($this->any())
            ->method('getDuration')
            ->willReturn(25);

        $this->aggregator->aggregate($benchmarkFast);
        $this->assertFalse($this->aggregator->isCritical());

        $this->aggregator->aggregate($benchmarkSlow);
        $this->assertTrue($this->aggregator->isCritical());

        $this->assertSame(Logger::SEVERITY_CRITICAL, $this->aggregator->getSeverity());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::isCritical
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getSeverity
     */
    public function testIsCriticalByCount()
    {
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));

        $this->assertFalse($this->aggregator->isCritical());

        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));

        $this->assertTrue($this->aggregator->isCritical());
        $this->assertSame(Logger::SEVERITY_CRITICAL, $this->aggregator->getSeverity());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getSeverity
     */
    public function testgetSeverityInfo()
    {
        $this->assertSame(Logger::SEVERITY_INFO, $this->aggregator->getSeverity());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getSeverity
     */
    public function testgetSeverityDebug()
    {
        $this->aggregator->aggregate($this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface'));

        $this->assertSame(Logger::SEVERITY_DEBUG, $this->aggregator->getSeverity());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::isCritical
     */
    public function testIsCritical()
    {
        $this->assertFalse($this->aggregator->isCritical());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getCountWarning
     */
    public function testGetCountWarning()
    {
        $this->assertSame(10, $this->aggregator->getCountWarning());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getCountCritical
     */
    public function testGetCountCritical()
    {
        $this->assertSame(20, $this->aggregator->getCountCritical());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getDurationWarning
     */
    public function testGetDurationWarning()
    {
        $this->assertSame(10, $this->aggregator->getDurationWarning());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\AbstractAggregator::getDurationCritical
     */
    public function testGetDurationCritical()
    {
        $this->assertSame(20, $this->aggregator->getDurationCritical());
    }
}

abstract class TestableAbstractAggregator extends AbstractAggregator
{
    /**
     * @param AggregationInterface $total
     */
    public function setTotal(AggregationInterface $total)
    {
        $this->total = $total;
    }

    /**
     * @param string $command
     * @param AggregationInterface[] $aggregations
     */
    public function setAggregations($command, $aggregations)
    {
        $this->aggregations[$command] = $aggregations;
    }
}
