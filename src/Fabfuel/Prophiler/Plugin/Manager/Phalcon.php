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
use Phalcon\DI\Injectable;

class Phalcon extends Injectable
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
     * Register all event manager plugins
     */
    public function register()
    {
        $this->registerDatabase();
        $this->registerDispatcher();
        $this->registerView();
    }

    /**
     * Register database AdapterPlugin in "db" event manager
     *
     * @return bool
     */
    public function registerDatabase()
    {
        if ($this->ensureEventsManager($this->db)) {
            $this->db->getEventsManager()->attach('db', AdapterPlugin::getInstance($this->getProfiler()));

            return true;
        }

        return false;
    }

    /**
     * Register DispatcherPlugin in "dispatcher" event manager
     *
     * @return bool
     */
    public function registerDispatcher()
    {
        if ($this->ensureEventsManager($this->dispatcher)) {
            $this->dispatcher->getEventsManager()->attach('dispatch', DispatcherPlugin::getInstance($this->getProfiler()));

            return true;
        }

        return false;
    }

    /**
     * Register ViewPlugin in common event manager
     *
     * We can not get the potentially custom events manager from the view, as the view is set up during
     * application and module bootstrapping. It does not exist before $application->handle()
     *
     * @return bool
     */
    public function registerView()
    {
        $this->eventsManager->attach('view', ViewPlugin::getInstance($this->getProfiler()));

        return true;
    }

    /**
     * @param object $service
     * @return bool
     */
    protected function ensureEventsManager($service)
    {
        if (!method_exists($service, 'getEventsManager')) {
            return false;
        }

        if (!$service->getEventsManager() && method_exists($service, 'setEventsManager')) {
            $service->setEventsManager($this->eventsManager);
        }

        return true;
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
