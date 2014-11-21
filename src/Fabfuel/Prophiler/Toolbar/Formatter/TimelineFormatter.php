<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 17.11.14, 07:45 
 */
namespace Fabfuel\Prophiler\Toolbar\Formatter;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;
use Fabfuel\Prophiler\ProfilerInterface;

class TimelineFormatter
{
    /**
     * @var ProfilerInterface
     */
    protected $profiler;

    /**
     * @var BenchmarkInterface
     */
    protected $benchmark;

    /**
     * @param ProfilerInterface $profiler
     */
    public function __construct(ProfilerInterface $profiler)
    {
        $this->setProfiler($profiler);
    }

    public function getWidth()
    {
        return round($this->getBenchmark()->getDuration() / $this->getProfiler()->getDuration() * 100, 2);
    }

    public function getOffset()
    {
        $offset = $this->getBenchmark()->getStartTime() - $this->getProfiler()->getStartTime();
        return round($offset / $this->getProfiler()->getDuration() * 100, 2);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return spl_object_hash($this->getBenchmark());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getBenchmark()->getName();
    }

    /**
     * @return string
     */
    public function getComponent()
    {
        return $this->getBenchmark()->getComponent();
    }

    /**
     * @return string
     */
    public function getMemoryUsage()
    {
        return sprintf('%05.2f MB', ($this->getBenchmark()->getMemoryUsage() /1024 /1024 ));
    }

    /**
     * @return string
     */
    public function getDuration()
    {
        return sprintf('%05.2f ms', ($this->getBenchmark()->getDuration() * 1000));
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        switch ($this->getBenchmark()->getComponent()) {
            case 'MongoDB':
                return 'success';
            default:
                return 'primary';
        }
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        switch ($this->getBenchmark()->getComponent()) {
            case 'MongoDB':
                return 'leaf';
            default:
                return 'cog';
        }
    }

    /**
     * @return double
     */
    public function getStartTime()
    {
        return $this->getBenchmark()->getStartTime();
    }

    /**
     * @return double
     */
    public function getEndTime()
    {
        return $this->getBenchmark()->getEndTime();
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->getBenchmark()->getMetadata();
    }

    /**
     * @return BenchmarkInterface
     */
    public function getBenchmark()
    {
        return $this->benchmark;
    }

    /**
     * @param BenchmarkInterface $benchmark
     */
    public function setBenchmark(BenchmarkInterface $benchmark)
    {
        $this->benchmark = $benchmark;
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
