<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 25.11.14, 07:16
 */
namespace Fabfuel\Prophiler\Iterator;

use Fabfuel\Prophiler\Profiler;

class ComponentFilteredIteratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ComponentFilteredIterator
     */
    protected $iterator;

    /**
     * @var Profiler|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $profiler;

    public function setUp()
    {
        $this->profiler = $this->getMock('Fabfuel\Prophiler\Profiler', ['addBechmark']);
    }

    /**
     * @covers Fabfuel\Prophiler\Iterator\ComponentFilteredIterator::__construct
     * @covers Fabfuel\Prophiler\Iterator\ComponentFilteredIterator::accept
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testAccept()
    {
        $benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $benchmark->expects($this->any())
            ->method('getComponent')
            ->willReturn('Foobar');

        $this->profiler->addBenchmark($benchmark);

        $iterator = new ComponentFilteredIterator($this->profiler, 'Foobar');
        $iterator->rewind();

        $this->assertTrue($iterator->accept());
    }

    /**
     * @covers Fabfuel\Prophiler\Iterator\ComponentFilteredIterator::count
     * @uses Fabfuel\Prophiler\Iterator\ComponentFilteredIterator
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testCount()
    {
        $benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');

        $benchmark->expects($this->any())
            ->method('getComponent')
            ->willReturn('Foobar');

        $iterator = new ComponentFilteredIterator($this->profiler, 'Foobar');

        $this->assertSame(0, count($iterator));

        $this->profiler->addBenchmark($benchmark);
        $this->assertSame(1, count($iterator));
    }
}
