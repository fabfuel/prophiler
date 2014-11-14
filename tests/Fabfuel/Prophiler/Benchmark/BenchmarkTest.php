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
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::setMetadata
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
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::setMetadata
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::setComponent
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getDuration
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::start
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::stop
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getStart
     * @covers Fabfuel\Prophiler\Benchmark\Benchmark::getEnd
     */
    public function testCalculation()
    {
        $name = 'Lorem\Ipsum::foobar';

        $benchmark = new Benchmark($name);

        $this->assertSame(0.0, $benchmark->getEnd());
        $this->assertSame(0.0, $benchmark->getStart());
        $this->assertSame(0.0, $benchmark->getDuration());

        $benchmark->start();
        $benchmark->stop();

        $this->assertGreaterThan($benchmark->getStart(), microtime(true));
        $this->assertGreaterThan($benchmark->getEnd(), microtime(true));
        $this->assertGreaterThan($benchmark->getStart(), $benchmark->getEnd());

        $this->assertGreaterThan(0, $benchmark->getDuration());

        $this->assertInternalType('float', $benchmark->getEnd());
        $this->assertInternalType('float', $benchmark->getStart());
        $this->assertInternalType('float', $benchmark->getDuration());
    }
}
