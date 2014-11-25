<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 17.11.14, 08:26
 */
namespace Fabfuel\Prophiler\Toolbar\Formatter;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;
use Fabfuel\Prophiler\ProfilerInterface;

class TimelineFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BenchmarkFormatter
     */
    protected $formatter;

    /**
     * @var ProfilerInterface
     */
    protected $profiler;

    /**
     * @var BenchmarkInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $benchmark;

    public function setUp()
    {
        $this->benchmark = $this->getBenchmarkMock();
        $this->profiler = $this->getProfilerMock();

        $this->formatter = new TimelineFormatter($this->profiler);
        $this->formatter->setBenchmark($this->benchmark);
    }

    /**
     * @covers Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter::__construct
     * @covers Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter::setProfiler
     * @covers Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter::getProfiler
     * @uses Fabfuel\Prophiler\Toolbar\Formatter\BenchmarkFormatterAbstract
     */
    public function testSetAndGetProfiler()
    {
        $profiler = $this->getProfilerMock();
        $formatter = new TimelineFormatter($profiler);
        $this->assertSame($profiler, $formatter->getProfiler());

        $anotherProfiler = $this->getProfilerMock();
        $this->assertNotSame($anotherProfiler, $formatter->getProfiler());

        $formatter->setProfiler($anotherProfiler);
        $this->assertSame($anotherProfiler, $formatter->getProfiler());
    }

    /**
     * @covers Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter::getWidth
     * @uses Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter
     * @uses Fabfuel\Prophiler\Toolbar\Formatter\BenchmarkFormatterAbstract
     */
    public function testGetWidth()
    {
        $durationBenchmark = 50;
        $durationProfiler = 100;

        $this->benchmark->expects($this->once())
            ->method('getDuration')
            ->willReturn($durationBenchmark);

        $this->profiler->expects($this->once())
            ->method('getDuration')
            ->willReturn($durationProfiler);

        $expectedWidth = round(($durationBenchmark/($durationProfiler * TimelineFormatter::TIMEBUFFER_FACTOR) *100), 2);

        $this->assertSame($expectedWidth, $this->formatter->getWidth());
    }

    /**
     * @covers Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter::getOffset
     * @uses Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter
     * @uses Fabfuel\Prophiler\Toolbar\Formatter\BenchmarkFormatterAbstract
     */
    public function testGetOffset()
    {
        $startTimeBenchmark = 100000;
        $startTimeProfiler  = 100050;
        $durationProfiler = 100;

        $this->benchmark->expects($this->once())
            ->method('getStartTime')
            ->willReturn($startTimeBenchmark);

        $this->profiler->expects($this->once())
            ->method('getStartTime')
            ->willReturn($startTimeProfiler);

        $this->profiler->expects($this->once())
            ->method('getDuration')
            ->willReturn($durationProfiler);

        $offset = $startTimeBenchmark - $startTimeProfiler;
        $expectedOffset = round($offset / ($durationProfiler * TimelineFormatter::TIMEBUFFER_FACTOR) * 100, 2);

        $this->assertSame($expectedOffset, $this->formatter->getOffset());
    }

    /**
     * @return BenchmarkInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getBenchmarkMock()
    {
        return $this->getMockBuilder('Fabfuel\Prophiler\Benchmark\Benchmark')
        ->disableOriginalConstructor()
        ->getMock();
    }
    /**
     * @return ProfilerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getProfilerMock()
    {
        return $this->getMockBuilder('Fabfuel\Prophiler\Profiler')
        ->disableOriginalConstructor()
        ->getMock();
    }
}
