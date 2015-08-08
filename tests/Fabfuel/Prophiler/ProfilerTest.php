<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 07:39
 */
namespace Fabfuel\Prophiler;

use Fabfuel\Prophiler\Benchmark\BenchmarkFactory;

class ProfilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Profiler
     */
    protected $profiler;

    protected function setUp()
    {
        $this->profiler = new Profiler;
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::getDuration
     * @covers Fabfuel\Prophiler\Profiler::getStartTime
     * @uses   Fabfuel\Prophiler\Profiler
     */
    public function testGetDuration()
    {
        usleep(1);
        $this->assertGreaterThan(0, $this->profiler->getDuration());
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::getDuration
     * @uses   Fabfuel\Prophiler\Profiler
     * @uses   Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     */
    public function testGetDurationFromLastBenchmark()
    {
        $benchmark = $this->profiler->start('benchmark');
        $this->profiler->stop($benchmark);

        $this->assertSame(
            ($benchmark->getEndTime() - $this->profiler->getStartTime()) * 1000,
            $this->profiler->getDuration()
        );
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::getLastBenchmark
     * @uses   Fabfuel\Prophiler\Profiler
     * @uses   Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     */
    public function testGetLastBenchmark()
    {
        $benchmark = $this->profiler->start('benchmark');
        $this->assertSame($benchmark, $this->profiler->getLastBenchmark());
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::getLastBenchmark
     * @uses   Fabfuel\Prophiler\Profiler
     * @uses   Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     * @expectedException \Fabfuel\Prophiler\Exception\UnknownBenchmarkException
     * @expectedExceptionMessage No benchmarks to return
     */
    public function testGetLastBenchmarkWithoutBenchmarks()
    {
        $this->assertSame(null, $this->profiler->getLastBenchmark());
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::__construct
     * @covers Fabfuel\Prophiler\Profiler::count
     * @covers Fabfuel\Prophiler\Profiler::addBenchmark
     * @covers Fabfuel\Prophiler\Profiler::getBenchmarks
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     * @uses   Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testAddAndCountBenchmarks()
    {
        $benchmark1 = BenchmarkFactory::getBenchmark('fooabar');
        $benchmark2 = BenchmarkFactory::getBenchmark('lorem');
        $benchmark3 = BenchmarkFactory::getBenchmark('ipsum');

        $profiler = $this->profiler
            ->addBenchmark($benchmark1)
            ->addBenchmark($benchmark2)
            ->addBenchmark($benchmark3);

        $this->assertSame($profiler, $this->profiler);
        $this->assertSame(3, $this->profiler->count());

        $benchmarks = $this->profiler->getBenchmarks();

        $this->assertTrue(isset($benchmarks[spl_object_hash($benchmark1)]));
        $this->assertTrue(isset($benchmarks[spl_object_hash($benchmark2)]));
        $this->assertTrue(isset($benchmarks[spl_object_hash($benchmark3)]));
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::start
     * @uses   Fabfuel\Prophiler\Profiler
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     * @uses   Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkInterface
     */
    public function testStart()
    {
        $name = 'foobar';
        $metadata = ['lorem' => 'ipsum'];

        $benchmark = $this->profiler->start($name, $metadata);

        $this->assertSame(1, count($this->profiler));
        $this->assertInstanceOf(
            '\Fabfuel\Prophiler\Benchmark\BenchmarkInterface',
            $benchmark
        );
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::stop
     * @uses   Fabfuel\Prophiler\Profiler
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     * @uses   Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkInterface
     */
    public function testStop()
    {
        $name = 'foobar';
        $metadataStart = ['lorem' => 'ipsum'];
        $metadataStop = ['additional' => 'stop'];

        $benchmark = $this->profiler->start($name, $metadataStart);

        $this->assertSame($metadataStart, $benchmark->getMetadata());

        usleep(1);
        $this->assertGreaterThan(0, $benchmark->getDuration());
        $result = $this->profiler->stop($benchmark, $metadataStop);
        $duration = $benchmark->getDuration();

        usleep(1);
        $this->assertSame($benchmark, $result);
        $this->assertSame($duration, $benchmark->getDuration());

        $this->assertArrayHasKey('additional', $benchmark->getMetadata());
        $this->assertSame(
            array_merge($metadataStart, $metadataStop),
            $benchmark->getMetadata()
        );
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::stop
     * @uses   Fabfuel\Prophiler\Profiler
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     * @uses   Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkInterface
     */
    public function testStopLastBenchmark()
    {
        $name = 'foobar';
        $metadataStart = ['lorem' => 'ipsum'];
        $metadataStop = ['additional' => 'stop'];

        $benchmark = $this->profiler->start($name, $metadataStart);

        $this->assertSame($metadataStart, $benchmark->getMetadata());

        usleep(1);
        $this->assertGreaterThan(0, $benchmark->getDuration());
        $result = $this->profiler->stop(null, $metadataStop);
        $duration = $benchmark->getDuration();

        usleep(1);
        $this->assertSame($benchmark, $result);
        $this->assertSame($duration, $benchmark->getDuration());

        $this->assertArrayHasKey('additional', $benchmark->getMetadata());
        $this->assertSame(
            array_merge($metadataStart, $metadataStop),
            $benchmark->getMetadata()
        );
    }

    /**
     * @expectedException \Fabfuel\Prophiler\Exception\UnknownBenchmarkException
     * @expectedExceptionMessage No benchmarks to return last one
     */
    public function testAnonymousStopWithoutBenchmark()
    {
        $this->profiler->stop();
    }

    /**
     * @expectedException \Fabfuel\Prophiler\Exception\UnknownBenchmarkException
     * @expectedExceptionMessage Benchmark not present in profiler
     */
    public function testStopUnknownBenchmark()
    {
        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $this->profiler->stop($benchmark);
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::current
     * @covers Fabfuel\Prophiler\Profiler::next
     * @covers Fabfuel\Prophiler\Profiler::valid
     * @covers Fabfuel\Prophiler\Profiler::rewind
     * @covers Fabfuel\Prophiler\Profiler::key
     * @uses   Fabfuel\Prophiler\Profiler
     * @uses   Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     */
    public function testIteration()
    {
        $benchmark1 = $this->profiler->start('Foobar');
        $this->profiler->stop($benchmark1);

        $benchmark2 = $this->profiler->start('Loremk Ipsum');
        $this->profiler->stop($benchmark2);

        $this->profiler->rewind();

        $this->assertSame(spl_object_hash($benchmark1), $this->profiler->key());
        $this->assertTrue($this->profiler->valid());
        $this->assertSame($benchmark1, $this->profiler->current());

        $this->profiler->next();

        $this->assertSame(spl_object_hash($benchmark2), $this->profiler->key());
        $this->assertTrue($this->profiler->valid());
        $this->assertSame($benchmark2, $this->profiler->current());

        $this->profiler->next();
        $this->assertFalse($this->profiler->valid());
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::addAggregator
     * @covers Fabfuel\Prophiler\Profiler::getAggregators
     */
    public function testAddAggregator()
    {
        $this->assertCount(0, $this->profiler->getAggregators());

        $aggregator = $this->getMock('\Fabfuel\Prophiler\AggregatorInterface');
        $this->profiler->addAggregator($aggregator);

        $this->assertCount(1, $this->profiler->getAggregators());

        $firstAggregator = current($this->profiler->getAggregators());
        $this->assertSame($aggregator, $firstAggregator);
    }

    public function testAggregate()
    {
        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $aggregator = $this->getMock('\Fabfuel\Prophiler\AggregatorInterface');

        $aggregator->expects($this->once())
            ->method('aggregate')
            ->with($benchmark);

        $this->profiler->addAggregator($aggregator);
        $this->profiler->aggregate($benchmark);
    }
}
