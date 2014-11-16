<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 14.11.14, 08:39 
 */
namespace Fabfuel\Prophiler\Plugin\Phalcon\Mvc;

use Fabfuel\Prophiler\Plugin\PluginAbstract;
use Fabfuel\Prophiler\ProfilerInterface;
use Phalcon\Events\Event;
use Phalcon\Mvc\DispatcherInterface;

/**
 * Class DispatcherPlugin
 * @package Rocket\Toolbar\Plugin
 */
class DispatcherPlugin extends PluginAbstract
{
    /**
     * @var string
     */
    protected $tokenDispatch;

    /**
     * @var string
     */
    protected $tokenRoute;

    /**
     * @var DispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param ProfilerInterface $profiler
     * @param DispatcherInterface $dispatcher
     */
    public function __construct(ProfilerInterface $profiler, DispatcherInterface $dispatcher)
    {
        $this->setProfiler($profiler);
        $this->setDispatcher($dispatcher);
    }


    /**
     * Start dispatch loop benchmark
     *
     * @param Event $event
     */
    public function beforeDispatchLoop(Event $event)
    {
        $name = get_class($event->getSource()) . '::dispatchLoop';
        $this->tokenDispatch = $this->getProfiler()->start($name, [], 'Dispatcher');
    }

    /**
     * Stop dispatch loop benchmark
     */
    public function afterDispatchLoop()
    {
        $this->getProfiler()->stop($this->tokenDispatch);
    }

    /**
     * Start execute route benchmark
     *
     * @param Event $event
     */
    public function beforeExecuteRoute(Event $event)
    {
        $name = get_class($event->getSource()) . '::executeRoute';
        $metadata = [
            'class' => get_class($this->getDispatcher()->getActiveController()),
            'controller' => $this->getDispatcher()->getControllerName(),
            'action' => $this->getDispatcher()->getActionName(),
            'params' => $this->getDispatcher()->getParams(),
        ];

        $this->tokenRoute = $this->getProfiler()->start($name, $metadata, 'Dispatcher');
    }

    /**
     * Stop dispatch loop benchmark
     */
    public function afterExecuteRoute()
    {
        $this->getProfiler()->stop($this->tokenRoute);
    }

    /**
     * @return DispatcherInterface
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * @param DispatcherInterface $dispatcher
     */
    public function setDispatcher($dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}
