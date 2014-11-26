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
        usleep(100);
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
        $benchmarkToken = $this->profiler->start('benchmark');
        $benchmark = $this->profiler->stop($benchmarkToken);

        $this->assertSame(
            $benchmark->getEndTime() - $this->profiler->getStartTime(),
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
        $benchmarkToken = $this->profiler->start('benchmark');
        $benchmark = $this->profiler->stop($benchmarkToken);

        $this->assertSame($benchmark, $this->profiler->getLastBenchmark());
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::getLastBenchmark
     * @uses   Fabfuel\Prophiler\Profiler
     * @uses   Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkFactory
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

        $token1 = $this->profiler->addBenchmark($benchmark1);
        $token2 = $this->profiler->addBenchmark($benchmark2);
        $token3 = $this->profiler->addBenchmark($benchmark3);

        $this->assertNotSame($token1, $token2);
        $this->assertNotSame($token2, $token3);
        $this->assertNotSame($token1, $token3);

        $this->assertInternalType('string', $token1);
        $this->assertSame(3, count($this->profiler));

        $benchmarks = $this->profiler->getBenchmarks();

        $this->assertTrue(isset($benchmarks[0]));
        $this->assertTrue(isset($benchmarks[1]));
        $this->assertTrue(isset($benchmarks[2]));
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::start
     * @uses   Fabfuel\Prophiler\Profiler
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkInterface
     */
    public function testStart()
    {
        $name = 'foobar';
        $metadata = ['lorem' => 'ipsum'];

        $token = $this->profiler->start($name, $metadata);

        $this->assertInternalType('string', $token);
        $this->assertSame(1, count($this->profiler));

        $benchmark = $this->profiler->getBenchmark($token);
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
     */
    public function testStop()
    {
        $metadata = ['foo'];

        $benchmark = $this->getMock('\Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $benchmark->expects($this->once())->method('addMetadata')->with($metadata);
        $benchmark->expects($this->once())->method('stop');

        $token = $this->profiler->addBenchmark($benchmark);
        $this->profiler->stop($token, $metadata);
    }

    /**
     * @expectedException \Fabfuel\Prophiler\Exception\UnknownBenchmarkException
     * @expectedExceptionMessage Unknown benchmark
     */
    public function testGetBenchmarkWithInvalidToken()
    {
        $this->profiler->getBenchmark('foobar');
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::getBenchmark
     * @uses   Fabfuel\Prophiler\Profiler
     * @uses   Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     */
    public function testGetBenchmarkFromToken()
    {
        $token = $this->profiler->start('Foobar');
        $benchmark = $this->profiler->getBenchmark($token);
        $this->assertInstanceOf(
            'Fabfuel\Prophiler\Benchmark\BenchmarkInterface',
            $benchmark
        );
        $this->assertSame(
            $this->profiler->getBenchmark($token),
            $this->profiler->getBenchmark()
        );
    }

    /**
     * @covers Fabfuel\Prophiler\Profiler::getBenchmark
     * @uses   Fabfuel\Prophiler\Profiler
     * @uses   Fabfuel\Prophiler\Benchmark\Benchmark
     * @uses   Fabfuel\Prophiler\Benchmark\BenchmarkFactory
     */
    public function testGetBenchmarkWithoutToken()
    {
        $this->assertNull($this->profiler->getBenchmark());

        $this->profiler->start('Foobar');
        $this->assertInstanceOf(
            'Fabfuel\Prophiler\Benchmark\BenchmarkInterface',
            $this->profiler->getBenchmark()
        );
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
        $this->profiler->stop($this->profiler->start('Foobar'));
        $benchmark1 = $this->profiler->getLastBenchmark();

        $this->profiler->stop($this->profiler->start('Loremk Ipsum'));
        $benchmark2 = $this->profiler->getLastBenchmark();

        $this->assertSame(0, $this->profiler->key());
        $this->assertTrue($this->profiler->valid());
        $this->assertSame($benchmark1, $this->profiler->current());

        $this->profiler->next();
        $this->assertSame(1, $this->profiler->key());
        $this->assertTrue($this->profiler->valid());
        $this->assertSame($benchmark2, $this->profiler->current());

        $this->profiler->next();
        $this->assertSame(2, $this->profiler->key());
        $this->assertFalse($this->profiler->valid());

        $this->profiler->rewind();
        $this->assertSame(0, $this->profiler->key());
        $this->assertTrue($this->profiler->valid());
    }
}
