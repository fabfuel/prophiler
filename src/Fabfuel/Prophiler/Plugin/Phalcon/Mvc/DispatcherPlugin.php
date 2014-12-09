<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 14.11.14, 08:39 
 */
namespace Fabfuel\Prophiler\Plugin\Phalcon\Mvc;

use Fabfuel\Prophiler\Benchmark\BenchmarkInterface;
use Fabfuel\Prophiler\Plugin\PluginAbstract;
use Phalcon\Events\Event;
use Phalcon\Mvc\DispatcherInterface;

/**
 * Class DispatcherPlugin
 */
class DispatcherPlugin extends PluginAbstract
{
    /**
     * @var BenchmarkInterface
     */
    protected $benchmarkDispatch;

    /**
     * @var BenchmarkInterface
     */
    protected $benchmarkRoute;

    /**
     * Start dispatch loop benchmark
     *
     * @param Event $event
     */
    public function beforeDispatchLoop(Event $event)
    {
        $name = get_class($event->getSource()) . '::dispatchLoop';
        $this->benchmarkDispatch = $this->getProfiler()->start($name, [], 'Dispatcher');
    }

    /**
     * Stop dispatch loop benchmark
     */
    public function afterDispatchLoop()
    {
        $this->getProfiler()->stop($this->benchmarkDispatch);
    }

    /**
     * Start execute route benchmark
     *
     * @param Event $event
     * @param DispatcherInterface $dispatcher
     */
    public function beforeExecuteRoute(Event $event, DispatcherInterface $dispatcher)
    {
        $name = get_class($event->getSource()) . '::executeRoute';
        $metadata = [
            'executed' => sprintf('%s::%sAction', get_class($dispatcher->getActiveController()), $dispatcher->getActionName()),
            'controller' => $dispatcher->getControllerName(),
            'action' => $dispatcher->getActionName(),
            'params' => $dispatcher->getParams(),
        ];

        $this->benchmarkRoute = $this->getProfiler()->start($name, $metadata, 'Dispatcher');
    }

    /**
     * Stop dispatch loop benchmark
     */
    public function afterExecuteRoute()
    {
        $this->getProfiler()->stop($this->benchmarkRoute);
    }
}
