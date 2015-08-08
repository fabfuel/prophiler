<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 17.11.14, 07:45 
 */
namespace Fabfuel\Prophiler\Toolbar\Formatter;

use Fabfuel\Prophiler\ProfilerInterface;

class TimelineFormatter extends BenchmarkFormatterAbstract
{
    const TIMEBUFFER_FACTOR = 1.05;

    /**
     * @var ProfilerInterface
     */
    protected $profiler;

    /**
     * @param ProfilerInterface $profiler
     */
    public function __construct(ProfilerInterface $profiler)
    {
        $this->setProfiler($profiler);
    }

    /**
     * @return string
     */
    public function getWidth()
    {
        $widthPercentage = $this->getBenchmark()->getDuration() / $this->getProfilerDuration() * 100;
        return number_format($widthPercentage, 2, '.', '');
    }

    /**
     * @return string
     */
    public function getOffset()
    {
        $offset = ($this->getBenchmark()->getStartTime() - $this->getProfiler()->getStartTime()) * 1000;
        $offsetPercentage = $offset / $this->getProfilerDuration() * 100;
        return number_format($offsetPercentage, 2, '.', '');
    }

    /**
     * @return ProfilerInterface
     */
    public function getProfiler()
    {
        return $this->profiler;
    }

    /**
     * @param ProfilerInterface $profiler
     */
    public function setProfiler(ProfilerInterface $profiler)
    {
        $this->profiler = $profiler;
    }

    /**
     * @return float
     */
    protected function getProfilerDuration()
    {
        return $this->getProfiler()->getDuration() * self::TIMEBUFFER_FACTOR;
    }
}
