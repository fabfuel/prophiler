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
     * @var TimelineFormatter|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $formatter;

    /**
     * @var ProfilerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $profiler;

    /**
     * @var BenchmarkInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $benchmark;

    public function setUp()
    {
        $this->benchmark = $this->getMock('Fabfuel\Prophiler\Benchmark\BenchmarkInterface');
        $this->profiler = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');

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
        $profilerA = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');
        $profilerB = $this->getMock('Fabfuel\Prophiler\ProfilerInterface');

        $formatter = new TimelineFormatter($profilerA);
        $this->assertSame($profilerA, $formatter->getProfiler());

        $formatter->setProfiler($profilerB);
        $this->assertSame($profilerB, $formatter->getProfiler());
    }

    /**
     * @covers Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter::getWidth
     * @covers Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter::getProfilerDuration
     * @uses Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter
     * @uses Fabfuel\Prophiler\Toolbar\Formatter\BenchmarkFormatterAbstract
     */
    public function testGetWidth()
    {
        $durationBenchmark = 50;
        $durationProfiler = 100;

        $this->benchmark->expects($this->any())
            ->method('getDuration')
            ->willReturn($durationBenchmark);

        $this->profiler->expects($this->any())
            ->method('getDuration')
            ->willReturn($durationProfiler);

        $expectedWidth = number_format(($durationBenchmark / ($durationProfiler * TimelineFormatter::TIMEBUFFER_FACTOR) * 100), 2, '.', '');

        $this->assertSame($expectedWidth, $this->formatter->getWidth());
    }

    /**
     * @covers Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter::getOffset
     * @covers Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter::getProfilerDuration
     * @uses Fabfuel\Prophiler\Toolbar\Formatter\TimelineFormatter
     * @uses Fabfuel\Prophiler\Toolbar\Formatter\BenchmarkFormatterAbstract
     */
    public function testGetOffset()
    {
        $startTimeBenchmark = 100000;
        $startTimeProfiler  = 100050;
        $durationProfiler = 100;

        $this->benchmark->expects($this->any())
            ->method('getStartTime')
            ->willReturn($startTimeBenchmark);

        $this->profiler->expects($this->any())
            ->method('getStartTime')
            ->willReturn($startTimeProfiler);

        $this->profiler->expects($this->any())
            ->method('getDuration')
            ->willReturn($durationProfiler);

        $offset = ($startTimeBenchmark - $startTimeProfiler) * 1000;
        $expectedOffset = number_format($offset / ($durationProfiler * TimelineFormatter::TIMEBUFFER_FACTOR) * 100, 2, '.', '');

        $this->assertSame($expectedOffset, $this->formatter->getOffset());
    }
}
