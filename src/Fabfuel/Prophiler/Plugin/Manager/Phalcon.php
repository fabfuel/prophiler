<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 18.11.14, 07:31
 */
namespace Fabfuel\Prophiler\Plugin\Manager;

use Fabfuel\Prophiler\ProfilerInterface;
use Fabfuel\Prophiler\Plugin\Phalcon\Db\AdapterPlugin;
use Fabfuel\Prophiler\Plugin\Phalcon\Mvc\DispatcherPlugin;
use Fabfuel\Prophiler\Plugin\Phalcon\Mvc\ViewPlugin;
use Phalcon\DiInterface;
use Phalcon\DI\InjectionAwareInterface;

class Phalcon implements InjectionAwareInterface
{
    /**
     * @var ProfilerInterface
     */
    protected $profiler;

    /**
     * @var
     */
    protected $dependencyInjection;

    /**
     * @param ProfilerInterface $profiler
     * @param DiInterface $dependencyInjection
     */
    public function __construct(ProfilerInterface $profiler, DiInterface $dependencyInjection)
    {
        $this->setProfiler($profiler);
        $this->setDI($dependencyInjection);
    }

    public function register()
    {
        $this->getDI()->get('eventsManager')->attach(
            'dispatch',
            DispatcherPlugin::getInstance($this->getProfiler())->setDI($this->getDI())
        );
        $this->getDI()->get('eventsManager')->attach(
            'view',
            ViewPlugin::getInstance($this->getProfiler())
        );
        $this->getDI()->get('eventsManager')->attach(
            'db',
            AdapterPlugin::getInstance($this->getProfiler())
        );
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
     * @return mixed
     */
    public function getDI()
    {
        return $this->dependencyInjection;
    }

    /**
     * @param mixed $dependencyInjection
     */
    public function setDI($dependencyInjection)
    {
        $this->dependencyInjection = $dependencyInjection;
    }
}
