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
     */
    public function registerDatabase()
    {
        if (!method_exists($this->db, 'getEventsManager')) {
            return;
        }

        if (!$this->db->getEventsManager() && method_exists($this->db, 'setEventsManager')) {
            $this->db->setEventsManager($this->eventsManager);
        }

        $this->db->getEventsManager()->attach('db', AdapterPlugin::getInstance($this->getProfiler()));
    }

    /**
     * Register ViewPlugin in "dispatcher" event manager
     */
    public function registerDispatcher()
    {
        if (!method_exists($this->dispatcher, 'getEventsManager')) {
            return;
        }

        if (!$this->dispatcher->getEventsManager() && method_exists($this->dispatcher, 'setEventsManager')) {
            $this->dispatcher->setEventsManager($this->eventsManager);
        }

        $this->dispatcher->getEventsManager()->attach('dispatch', DispatcherPlugin::getInstance($this->getProfiler()));
    }

    /**
     * Register ViewPlugin in "view" event manager
     */
    public function registerView()
    {
        if (!method_exists($this->view, 'getEventsManager')) {
            return;
        }

        if (!$this->view->getEventsManager() && method_exists($this->view, 'setEventsManager')) {
            $this->view->setEventsManager($this->eventsManager);
        }

        $this->view->getEventsManager()->attach('view', ViewPlugin::getInstance($this->getProfiler()));
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
