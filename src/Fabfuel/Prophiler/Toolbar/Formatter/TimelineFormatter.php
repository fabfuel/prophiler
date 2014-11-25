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
     * @return double
     */
    public function getWidth()
    {
        return round($this->getBenchmark()->getDuration() / ($this->getProfiler()->getDuration() * self::TIMEBUFFER_FACTOR) * 100, 2);
    }

    /**
     * @return double
     */
    public function getOffset()
    {
        $offset = $this->getBenchmark()->getStartTime() - $this->getProfiler()->getStartTime();
        return round($offset / ($this->getProfiler()->getDuration() * self::TIMEBUFFER_FACTOR) * 100, 2);
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
}
