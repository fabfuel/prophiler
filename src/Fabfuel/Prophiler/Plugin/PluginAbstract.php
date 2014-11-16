<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 16.11.14, 20:05 
 */
namespace Fabfuel\Prophiler\Plugin;

use Fabfuel\Prophiler\ProfilerInterface;

abstract class PluginAbstract
{
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
