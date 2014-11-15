<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 14.11.14, 08:39 
 */
namespace Fabfuel\Prophiler\Plugin\Phalcon\Mvc;

use Fabfuel\Prophiler\ProfilerInterface;
use Phalcon\DI\Injectable;
use Phalcon\Events\Event;

/**
 * Class Dispatcher
 * @package Rocket\Toolbar\Plugin
 * @property ProfilerInterface $profiler
 */
class Dispatcher extends Injectable
{
    /**
     * @var string
     */
    private $tokenDispatch;

    /**
     * @var string
     */
    private $tokenRoute;

    /**
     * Start dispatch loop benchmark
     *
     * @param Event $event
     */
    public function beforeDispatchLoop(Event $event)
    {
        $this->tokenDispatch = $this->profiler->start(get_class($event->getSource()) . '::dispatchLoop', [], 'Dispatcher');
    }

    /**
     * Stop dispatch loop benchmark
     */
    public function afterDispatchLoop()
    {
        $this->profiler->stop($this->tokenDispatch);
    }

    /**
     * Start execute route benchmark
     *
     * @param Event $event
     */
    public function beforeExecuteRoute(Event $event)
    {
        $metadata = [
            'module' => $this->router->getModuleName(),
            'controller' => $this->router->getControllerName(),
            'action' => $this->router->getActionName(),
            'params' => $this->router->getParams(),
            'class' => get_class($this->dispatcher->getActiveController()),
        ];

        $this->tokenRoute = $this->profiler->start(get_class($event->getSource()) . '::executeRoute', $metadata, 'Dispatcher');
    }

    /**
     * Stop dispatch loop benchmark
     */
    public function afterExecuteRoute()
    {
        $this->profiler->stop($this->tokenRoute);
    }
}
