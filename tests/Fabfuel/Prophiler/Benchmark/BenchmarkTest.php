<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 07:39 
 */
namespace Fabfuel\Prophiler;

use Fabfuel\Prophiler\Benchmark\Benchmark;

class BenchmarkTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Benchmark
     */
    protected $benchmark;

    /**
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::__construct
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::start
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getName
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::setName
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getMetadata
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::addMetadata
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getComponent
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::setComponent
     */
    public function testConstruct()
    {
        $name = 'Lorem\Ipsum::foobar';
        $metadata = ['lorem' => 'ipsum'];
        $component = 'Database';

        $benchmark = new Benchmark($name, $metadata, $component);

        $this->assertSame($name, $benchmark->getName());
        $this->assertSame($metadata, $benchmark->getMetadata());
        $this->assertSame($component, $benchmark->getComponent());
    }

    /**
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::__construct
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::setName
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::addMetadata
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::setComponent
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getDuration
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::start
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::stop
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getStartTime
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getEndTime
     */
    public function testTimeCalculation()
    {
        $name = 'Lorem\Ipsum::foobar';

        $benchmark = new Benchmark($name);

        $this->assertSame(0.0, $benchmark->getEndTime());
        $this->assertSame(0.0, $benchmark->getStartTime());
        $this->assertSame(0.0, $benchmark->getDuration());

        $benchmark->start();
        $benchmark->stop();

        $this->assertGreaterThan($benchmark->getStartTime(), microtime(true));
        $this->assertGreaterThan($benchmark->getEndTime(), microtime(true));
        $this->assertGreaterThan($benchmark->getStartTime(), $benchmark->getEndTime());

        $this->assertGreaterThan(0, $benchmark->getDuration());

        $this->assertInternalType('float', $benchmark->getEndTime());
        $this->assertInternalType('float', $benchmark->getStartTime());
        $this->assertInternalType('float', $benchmark->getDuration());
    }

    public function testMemoryCalculation()
    {
        $name = 'Lorem\Ipsum::foobar';

        $benchmark = new Benchmark($name);

        $benchmark->start();
        $memoryUsageStart = (double) memory_get_usage();

        $benchmark->stop();
        $memoryUsageEnd = (double) memory_get_usage();
        $memoryUsage = $memoryUsageEnd-$memoryUsageStart;
        $this->assertSame($memoryUsage, $benchmark->getMemoryUsage());

        $this->assertGreaterThan($benchmark->getMemoryUsageStart(), $benchmark->getMemoryUsageEnd());

        $memoryUse = ['lorem' => 'ipsum'];
        $memoryUse[] = 'foobar';

        $benchmark->stop();
        $this->assertGreaterThan($memoryUsage, $benchmark->getMemoryUsage());
    }
}
