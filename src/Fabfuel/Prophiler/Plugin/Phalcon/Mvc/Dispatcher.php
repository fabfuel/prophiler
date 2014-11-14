<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 14.11.14, 08:39 
 */
namespace Fabfuel\Prophiler\Plugin\Phalcon\Mvc;

use Fabfuel\Prophiler\ProfilerInterface;
use Phalcon\DI\Injectable;

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

    public function beforeDispatchLoop()
    {
        $this->tokenDispatch = $this->profiler->start('Phalcon\Mvc\Dispatcher::dispatchLoop', [], 'Dispatcher');
    }

    public function afterDispatchLoop()
    {
        $this->profiler->stop($this->tokenDispatch);
    }

    public function beforeExecuteRoute()
    {
        $metadata = [
            'module' => $this->router->getModuleName(),
            'controller' => $this->router->getControllerName(),
            'action' => $this->router->getActionName(),
            'params' => $this->router->getParams(),
            'class' => get_class($this->dispatcher->getActiveController()),
        ];

        $this->tokenRoute = $this->profiler->start('Phalcon\Mvc\Dispatcher::executeRoute', $metadata, 'Dispatcher');
    }

    public function afterExecuteRoute()
    {
        $this->profiler->stop($this->tokenRoute);
    }
}
