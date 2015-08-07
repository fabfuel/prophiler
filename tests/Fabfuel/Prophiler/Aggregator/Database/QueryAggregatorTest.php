<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 07.08.15, 07:54
 */
namespace Fabfuel\Prophiler\Aggregator\Database;

class QueryAggregatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QueryAggregator
     */
    protected $aggregator;

    public function setUp()
    {
        $this->aggregator = new QueryAggregator();
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\Database\QueryAggregator::accept
     */
    public function testAccept()
    {
        $validBenchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $validBenchmark->expects($this->any())
            ->method('getComponent')
            ->willReturn('Database');

        $invalidBenchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $invalidBenchmark->expects($this->any())
            ->method('getComponent')
            ->willReturn('Foobar');

        $this->assertTrue($this->aggregator->accept($validBenchmark));
        $this->assertFalse($this->aggregator->accept($invalidBenchmark));
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\Database\QueryAggregator::getCommand
     */
    public function testGetCommand()
    {
        $benchmarkWithQuery = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $benchmarkWithQuery->expects($this->any())
            ->method('getMetadataValue')
            ->with('query')
            ->willReturn('Lorem Ipsum');

        $this->assertSame('Lorem Ipsum', $this->aggregator->getCommand($benchmarkWithQuery));
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\Database\QueryAggregator::getCommand
     */
    public function testGetCommandFallback()
    {
        $benchmarkWithQuery = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $benchmarkWithQuery->expects($this->any())
            ->method('getMetadataValue')
            ->with('query')
            ->willReturn(null);

        $benchmarkWithQuery->expects($this->any())
            ->method('getName')
            ->willReturn('Foobar');

        $this->assertSame('Foobar', $this->aggregator->getCommand($benchmarkWithQuery));
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\Database\QueryAggregator::getIcon
     */
    public function testGetIcon()
    {
        $this->assertSame('<i class="fa fa-database"></i>', $this->aggregator->getIcon());
    }

    /**
     * @covers Fabfuel\Prophiler\Aggregator\Database\QueryAggregator::getTitle
     */
    public function testGetTitle()
    {
        $this->assertSame('Queries', $this->aggregator->getTitle());
    }
}
