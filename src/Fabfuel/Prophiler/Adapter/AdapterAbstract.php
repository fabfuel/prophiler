<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 14.11.14, 06:57 
 */
namespace Fabfuel\Prophiler\Adapter;

use Fabfuel\Prophiler\ProfilerInterface;

abstract class AdapterAbstract
{
    /**
     * @var ProfilerInterface
     */
    protected $profiler;

    public function __construct(ProfilerInterface $profiler)
    {
        $this->setProfiler($profiler);
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
