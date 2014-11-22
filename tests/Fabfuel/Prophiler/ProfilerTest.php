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
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testGetDuration()
    {
        $this->assertGreaterThan(0, $this->profiler->getDuration());
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::getDuration
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     */
    public function testGetDurationFromLastBenchmark()
    {
        $benchmarkToken = $this->profiler->start('benchmark');
        $benchmark = $this->profiler->stop($benchmarkToken);

        $this->assertSame($benchmark->getEndTime()-$this->profiler->getStartTime(), $this->profiler->getDuration());
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::getLastBenchmark
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     */
    public function testGetLastBenchmark()
    {
        $benchmarkToken = $this->profiler->start('benchmark');
        $benchmark = $this->profiler->stop($benchmarkToken);

        $this->assertSame($benchmark, $this->profiler->getLastBenchmark());
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::getLastBenchmark
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses Fabfuel\Prophiler\Benchmark\BenchmarkFactory
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
     * @uses Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testAddAndCountBenchmarks()
    {
        $benchmark1 = BenchmarkFactory::getBenchmark('fooabar');
        $benchmark2 = BenchmarkFactory::getBenchmark('lorem');
        $benchmark3 = BenchmarkFactory::getBenchmark('ipsum');

        $token1 = $this->profiler->addBenchmark($benchmark1);
        $token2 = $this->profiler->addBenchmark($benchmark2);
        $token3 = $this->profiler->addBenchmark($benchmark3);

        $this->assertNotSame($token1, $token2);
        $this->assertNotSame($token2, $token3);
        $this->assertNotSame($token1, $token3);

        $this->assertInternalType('string', $token1);
        $this->assertSame(3, count($this->profiler));

        $benchmarks = $this->profiler->getBenchmarks();

        $this->assertTrue(isset($benchmarks[$token1]));
        $this->assertTrue(isset($benchmarks[$token2]));
        $this->assertTrue(isset($benchmarks[$token3]));
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::start
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testStart()
    {
        $name = 'foobar';
        $metadata = ['lorem' => 'ipsum'];

        $token = $this->profiler->start($name, $metadata);

        $this->assertInternalType('string', $token);
        $this->assertSame(1, count($this->profiler));

        $benchmarks = $this->profiler->getBenchmarks();
        $this->assertTrue(isset($benchmarks[$token]));

        $benchmark = $benchmarks[$token];
        $this->assertInstanceOf('\Fabfuel\Prophiler\Benchmark\Benchmark', $benchmark);
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::stop
     * @uses Fabfuel\Prophiler\Profiler
     * @uses Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testStop()
    {
        $name = 'foobar';
        $metadataStart = ['lorem' => 'ipsum'];
        $metadataStop = ['additional' => 'stop'];

        $token = $this->profiler->start($name, $metadataStart);
        $benchmarks = $this->profiler->getBenchmarks();
        $benchmark = $benchmarks[$token];

        $this->assertSame($metadataStart, $benchmark->getMetadata());

        $duration1 = $benchmark->getDuration();
        $this->assertGreaterThan(0, $benchmark->getDuration());

        $benchmarkInstance = $this->profiler->stop($token, $metadataStop);
        $this->assertInstanceOf('Fabfuel\Prophiler\Benchmark\Benchmark', $benchmarkInstance);

        $duration2 = $benchmark->getDuration();
        $this->assertGreaterThan(0, $benchmark->getDuration());
        $this->assertGreaterThan($duration1, $duration2);

        $duration = $benchmark->getDuration();
        $this->assertSame($duration, $benchmark->getDuration());

        $this->assertArrayHasKey('additional', $benchmark->getMetadata());
        $this->assertSame(array_merge($metadataStart, $metadataStop), $benchmark->getMetadata());
    }

    /**
     * @expectedException \Fabfuel\Prophiler\Exception\UnknownBenchmarkException
     */
    public function testStopUnknownBenchmark()
    {
        $this->profiler->stop('foobar');
    }
}
