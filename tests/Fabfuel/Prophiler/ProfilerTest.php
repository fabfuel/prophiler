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
     * @covers Fabfuel\Prophiler\Profiler::__construct
     * @covers Fabfuel\Prophiler\Profiler::getDuration
     */
    public function testGetDuration()
    {
        $this->assertGreaterThan(0, $this->profiler->getDuration());
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
     * @covers Fabfuel\Prophiler\Profiler::__construct
     * @covers Fabfuel\Prophiler\Profiler::addBenchmark
     * @covers Fabfuel\Prophiler\Profiler::getBenchmarks
     * @covers Fabfuel\Prophiler\Profiler::count
     * @covers Fabfuel\Prophiler\Profiler::start
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
     * @covers Fabfuel\Prophiler\Profiler::__construct
     * @covers Fabfuel\Prophiler\Profiler::addBenchmark
     * @covers Fabfuel\Prophiler\Profiler::getBenchmarks
     * @covers Fabfuel\Prophiler\Profiler::start
     * @covers Fabfuel\Prophiler\Profiler::stop
     * @uses Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     * @uses Fabfuel\Prophiler\Benchmark\Benchmark
     */
    public function testStop()
    {
        $name = 'foobar';
        $metadata = ['lorem' => 'ipsum'];

        $token = $this->profiler->start($name, $metadata);
        $benchmarks = $this->profiler->getBenchmarks();
        $benchmark = $benchmarks[$token];

        $this->assertLessThan(0, $benchmark->getDuration());
        $this->profiler->stop($token);
        $this->assertGreaterThan(0, $benchmark->getDuration());

        $duration = $benchmark->getDuration();
        $this->assertSame($duration, $benchmark->getDuration());
    }

    /**
     * @expectedException \Fabfuel\Prophiler\Exception\UnknownBenchmarkException
     */
    public function testStopUnknownBenchmark()
    {
        $this->profiler->stop('foobar');
    }
}
