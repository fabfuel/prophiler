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
        $this->profiler = $this->getMockBuilder('Fabfuel\Prophiler\Profiler')
            ->disableOriginalConstructor()
            ->setMethods(['addBechmark'])
            ->getMock();
    }

    /**
     * @covers Fabfuel\Prophiler\Iterator\ComponentFilteredIterator::__construct
     * @covers Fabfuel\Prophiler\Iterator\ComponentFilteredIterator::accept
     * @uses Fabfuel\Prophiler\Profiler
     */
    public function testAccept()
    {
        $benchmark = $this->getMockBuilder('Fabfuel\Prophiler\Benchmark\Benchmark')
            ->disableOriginalConstructor()
            ->getMock();

        $benchmark->expects($this->exactly(2))
            ->method('getComponent')
            ->willReturn('Foobar');

        $this->profiler->addBenchmark($benchmark);

        $iterator = new ComponentFilteredIterator($this->profiler, 'Foobar');
        $iterator->rewind();

        $this->assertTrue($iterator->accept());
    }
}
