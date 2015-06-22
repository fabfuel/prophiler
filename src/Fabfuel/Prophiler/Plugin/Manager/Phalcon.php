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

    public function register()
    {
        $this->registerDatabase();
        $this->registerDispatcher();
        $this->registerView();
    }

    public function registerDatabase()
    {
        if (!$this->db->getEventsManager()) {
            $this->db->setEventsManager($this->eventsManager);
        }
        $this->eventsManager->attach('db', AdapterPlugin::getInstance($this->getProfiler()));
    }

    public function registerDispatcher()
    {
        if (!$this->dispatcher->getEventsManager()) {
            $this->dispatcher->setEventsManager($this->eventsManager);
        }
        $this->eventsManager->attach('dispatch', DispatcherPlugin::getInstance($this->getProfiler()));
    }

    public function registerView()
    {
        if (!$this->view->getEventsManager()) {
            $this->view->setEventsManager($this->eventsManager);
        }
        $this->eventsManager->attach('view', ViewPlugin::getInstance($this->getProfiler()));
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
