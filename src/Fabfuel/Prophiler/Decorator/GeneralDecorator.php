<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 21.06.15, 08:59 
 */
namespace Fabfuel\Prophiler\Decorator;

use Fabfuel\Prophiler\ProfilerInterface;

class GeneralDecorator extends AbstractDecorator
{
    /**
     * @param object $decorated
     * @param ProfilerInterface $profiler
     */
    public function __construct($decorated, ProfilerInterface $profiler)
    {
        $this->setDecorated($decorated);
        $this->setProfiler($profiler);
    }

    /**
     * @return string
     */
    public function getComponentName()
    {
        return current(explode('\\', get_class($this->getDecorated()), 2));
    }
}
